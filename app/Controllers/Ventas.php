<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\ProductModel;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;

class Ventas extends BaseController
{
    protected $ventaModel;
    protected $detalleVentaModel;
    protected $clienteModel;
    protected $productModel;

    public function __construct()
    {
        $this->ventaModel        = new VentaModel();
        $this->detalleVentaModel = new DetalleVentaModel();
        $this->clienteModel      = new ClienteModel();
        $this->productModel      = new ProductModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Historial de Ventas',
            'ventas' => $this->ventaModel->getVentasConRelaciones(),
        ];

        return view('ventas/index', $data);
    }

    public function crear()
    {
        $clientes = $this->clienteModel->orderBy('nombre', 'ASC')->findAll();
        // Productos que tengan stock disponible
        $productos = $this->productModel->where('stock >', 0)->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'titulo'    => 'Registrar Nueva Venta',
            'clientes'  => $clientes,
            'productos' => $productos,
        ];

        return view('ventas/crear', $data);
    }

    public function guardar()
    {
        $clienteId    = $this->request->getPost('cliente_id');
        $productosIds = $this->request->getPost('producto_id'); // array
        $cantidades   = $this->request->getPost('cantidad');    // array

        if (empty($clienteId)) {
            return redirect()->back()->withInput()->with('error', 'Por favor seleccione un cliente.');
        }

        if (empty($productosIds) || !is_array($productosIds) || count($productosIds) === 0) {
            return redirect()->back()->withInput()->with('error', 'Debe agregar al menos un producto a la venta.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $totalVenta = 0;
            $itemsParaGuardar = [];

            // Validar stock y calcular total
            foreach ($productosIds as $index => $prodId) {
                $cantidad = intval($cantidades[$index] ?? 0);

                if ($cantidad <= 0) {
                    continue;
                }

                $producto = $this->productModel->find($prodId);
                if (!$producto) {
                    throw new \Exception("Uno de los productos seleccionados no existe.");
                }

                if ($producto['stock'] < $cantidad) {
                    throw new \Exception("Stock insuficiente para: {$producto['nombre']}. Stock disponible: {$producto['stock']}.");
                }

                $precioUnitario = floatval($producto['precio']);
                $subtotal = round($precioUnitario * $cantidad, 2);
                $totalVenta += $subtotal;

                $itemsParaGuardar[] = [
                    'producto_id'     => $prodId,
                    'producto_nombre' => $producto['nombre'],
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'subtotal'        => $subtotal,
                    'nuevo_stock'     => $producto['stock'] - $cantidad,
                ];
            }

            if (empty($itemsParaGuardar)) {
                throw new \Exception("Debe ingresar cantidades válidas para los productos.");
            }

            // Generar número correlativo de factura
            $ultimoId = $this->ventaModel->selectMax('id')->first()['id'] ?? 0;
            $numeroFactura = 'FAC-' . date('Ymd') . '-' . str_pad($ultimoId + 1, 4, '0', STR_PAD_LEFT);

            // Insertar la venta
            $ventaData = [
                'numero_factura' => $numeroFactura,
                'cliente_id'     => $clienteId,
                'usuario_id'     => session()->get('user_id') ?? 1,
                'total'          => $totalVenta,
                'fecha'          => date('Y-m-d H:i:s'),
            ];

            $ventaId = $this->ventaModel->insert($ventaData);

            if (!$ventaId) {
                throw new \Exception("No se pudo registrar la venta en la base de datos.");
            }

            // Guardar detalles y descontar stock
            foreach ($itemsParaGuardar as $item) {
                $this->detalleVentaModel->insert([
                    'venta_id'        => $ventaId,
                    'producto_id'     => $item['producto_id'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal'        => $item['subtotal'],
                ]);

                // Actualizar stock del producto
                $this->productModel->update($item['producto_id'], [
                    'stock' => $item['nuevo_stock'],
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', 'Error durante la transacción de la venta.');
            }

            $db->transCommit();
            return redirect()->to('/ventas/detalle/' . $ventaId)->with('success', '¡Venta registrada con éxito!');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function detalle($id = null)
    {
        $venta = $this->ventaModel->getVentaPorId($id);

        if (!$venta) {
            return redirect()->to('/ventas')->with('error', 'La venta solicitada no existe.');
        }

        $detalles = $this->detalleVentaModel->getDetallesPorVenta($id);

        $data = [
            'titulo'   => 'Comprobante de Venta - ' . $venta['numero_factura'],
            'venta'    => $venta,
            'detalles' => $detalles,
        ];

        return view('ventas/detalle', $data);
    }

    public function eliminar($id = null)
    {
        $venta = $this->ventaModel->find($id);

        if (!$venta) {
            return redirect()->to('/ventas')->with('error', 'La venta no existe.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Restaurar el stock de los productos
            $detalles = $this->detalleVentaModel->where('venta_id', $id)->findAll();
            foreach ($detalles as $detalle) {
                $prod = $this->productModel->find($detalle['producto_id']);
                if ($prod) {
                    $this->productModel->update($detalle['producto_id'], [
                        'stock' => $prod['stock'] + $detalle['cantidad'],
                    ]);
                }
            }

            // Eliminar venta (cascada elimina detalle_ventas)
            $this->ventaModel->delete($id);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->to('/ventas')->with('error', 'No se pudo anular la venta.');
            }

            $db->transCommit();
            return redirect()->to('/ventas')->with('success', 'Venta anulada y stock devuelto al inventario exitosamente.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/ventas')->with('error', 'Error al anular la venta: ' . $e->getMessage());
        }
    }
}
