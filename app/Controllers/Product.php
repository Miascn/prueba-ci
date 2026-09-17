<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Product extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'titulo'    => 'Gestión de Productos',
            'productos' => $this->productModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('products/index', $data);
    }

    public function crear()
    {
        $data = [
            'titulo'   => 'Registrar Nuevo Producto',
            'producto' => null,
            'accion'   => 'crear',
        ];

        return view('products/form', $data);
    }

    public function guardar()
    {
        $reglas = [
            'codigo' => 'required|min_length[2]|max_length[50]|is_unique[productos.codigo]',
            'nombre' => 'required|min_length[2]|max_length[150]',
            'precio' => 'required|numeric|greater_than_equal_to[0]',
            'stock'  => 'required|integer|greater_than_equal_to[0]',
        ];

        $mensajes = [
            'codigo' => [
                'required'  => 'El código del producto es obligatorio.',
                'is_unique' => 'Ya existe un producto con este código.',
            ],
            'nombre' => [
                'required' => 'El nombre del producto es obligatorio.',
            ],
            'precio' => [
                'required' => 'El precio es obligatorio.',
                'numeric'  => 'El precio debe ser un número válido.',
            ],
            'stock' => [
                'required' => 'El stock es obligatorio.',
                'integer'  => 'El stock debe ser un número entero.',
            ],
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->save([
            'codigo'      => strtoupper(trim($this->request->getPost('codigo') ?? '')),
            'nombre'      => trim($this->request->getPost('nombre') ?? ''),
            'descripcion' => trim($this->request->getPost('descripcion') ?? ''),
            'precio'      => floatval($this->request->getPost('precio')),
            'stock'       => intval($this->request->getPost('stock')),
        ]);

        return redirect()->to('/productos')->with('success', 'Producto registrado exitosamente.');
    }

    public function editar($id = null)
    {
        $producto = $this->productModel->find($id);

        if (!$producto) {
            return redirect()->to('/productos')->with('error', 'El producto no existe.');
        }

        $data = [
            'titulo'   => 'Editar Producto',
            'producto' => $producto,
            'accion'   => 'editar',
        ];

        return view('products/form', $data);
    }

    public function actualizar($id = null)
    {
        $producto = $this->productModel->find($id);

        if (!$producto) {
            return redirect()->to('/productos')->with('error', 'El producto no existe.');
        }

        $reglas = [
            'codigo' => "required|min_length[2]|max_length[50]|is_unique[productos.codigo,id,{$id}]",
            'nombre' => 'required|min_length[2]|max_length[150]',
            'precio' => 'required|numeric|greater_than_equal_to[0]',
            'stock'  => 'required|integer|greater_than_equal_to[0]',
        ];

        $mensajes = [
            'codigo' => [
                'required'  => 'El código del producto es obligatorio.',
                'is_unique' => 'Ya existe un producto con este código.',
            ],
            'nombre' => [
                'required' => 'El nombre del producto es obligatorio.',
            ],
            'precio' => [
                'required' => 'El precio es obligatorio.',
                'numeric'  => 'El precio debe ser un número válido.',
            ],
            'stock' => [
                'required' => 'El stock es obligatorio.',
                'integer'  => 'El stock debe ser un número entero.',
            ],
        ];

        if (!$this->validate($reglas, $mensajes)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->update($id, [
            'codigo'      => strtoupper(trim($this->request->getPost('codigo') ?? '')),
            'nombre'      => trim($this->request->getPost('nombre') ?? ''),
            'descripcion' => trim($this->request->getPost('descripcion') ?? ''),
            'precio'      => floatval($this->request->getPost('precio')),
            'stock'       => intval($this->request->getPost('stock')),
        ]);

        return redirect()->to('/productos')->with('success', 'Producto actualizado exitosamente.');
    }

    public function eliminar($id = null)
    {
        $producto = $this->productModel->find($id);

        if (!$producto) {
            return redirect()->to('/productos')->with('error', 'El producto no existe.');
        }

        // Verificar si tiene ventas asociadas
        $db = \Config\Database::connect();
        $ventasAsociadas = $db->table('detalle_ventas')->where('producto_id', $id)->countAllResults();

        if ($ventasAsociadas > 0) {
            return redirect()->to('/productos')->with('error', 'No se puede eliminar el producto porque ya tiene ventas registradas.');
        }

        $this->productModel->delete($id);

        return redirect()->to('/productos')->with('success', 'Producto eliminado correctamente.');
    }
}
