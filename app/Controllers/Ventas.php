<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ProductModel;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;

class Ventas extends BaseController
{
    protected $ventaModel;
    protected $detalleModel;
    protected $clienteModel;
    protected $productModel;

    public function __construct()
    {
        $this->ventaModel   = new VentaModel();
        $this->detalleModel = new DetalleVentaModel();
        $this->clienteModel = new ClienteModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data['titulo'] = 'Historial de Ventas';
        $data['ventas'] = $this->ventaModel->getVentasConRelaciones();

        return view('ventas/index', $data);
    }

    public function crear()
    {
        $data['titulo']    = 'Registrar Venta';
        $data['clientes']  = $this->clienteModel->findAll();
        $data['productos'] = $this->productModel->where('stock >', 0)->findAll();

        return view('ventas/crear', $data);
    }

    public function guardar()
    {
        $clienteId  = $this->request->getPost('cliente_id');
        $productoId = $this->request->getPost('producto_id');
        $cantidad   = (int) $this->request->getPost('cantidad');

        if (!$clienteId || !$productoId || $cantidad <= 0) {
            return redirect()->back()->withInput()->with('error', 'Por favor complete todos los campos.');
        }

        $producto = $this->productModel->find($productoId);
        if (!$producto || $producto['stock'] < $cantidad) {
            return redirect()->back()->withInput()->with('error', 'Stock insuficiente para este producto.');
        }

        $subtotal = $producto['precio'] * $cantidad;

        // 1. Crear Venta
        $ventaId = $this->ventaModel->insert([
            'numero_factura' => 'V-' . date('Ymd-His'),
            'cliente_id'     => $clienteId,
            'usuario_id'     => session()->get('user_id') ?? 1,
            'total'          => $subtotal,
            'fecha'          => date('Y-m-d H:i:s'),
        ]);

        // 2. Crear Detalle de la Venta
        $this->detalleModel->insert([
            'venta_id'        => $ventaId,
            'producto_id'     => $productoId,
            'cantidad'        => $cantidad,
            'precio_unitario' => $producto['precio'],
            'subtotal'        => $subtotal,
        ]);

        // 3. Descontar Stock del Producto
        $this->productModel->update($productoId, [
            'stock' => $producto['stock'] - $cantidad,
        ]);

        return redirect()->to('/ventas')->with('success', 'Venta registrada con éxito.');
    }

    public function detalle($id)
    {
        $data['titulo']   = 'Comprobante de Venta';
        $data['venta']    = $this->ventaModel->getVentaPorId($id);
        $data['detalles'] = $this->detalleModel->getDetallesPorVenta($id);

        if (!$data['venta']) {
            return redirect()->to('/ventas')->with('error', 'Venta no encontrada.');
        }

        return view('ventas/detalle', $data);
    }

    public function eliminar($id)
    {
        // Devolver stock al inventario
        $detalles = $this->detalleModel->where('venta_id', $id)->findAll();
        foreach ($detalles as $d) {
            $p = $this->productModel->find($d['producto_id']);
            if ($p) {
                $this->productModel->update($d['producto_id'], [
                    'stock' => $p['stock'] + $d['cantidad'],
                ]);
            }
        }

        $this->ventaModel->delete($id);
        return redirect()->to('/ventas')->with('success', 'Venta eliminada y stock restaurado.');
    }
}
