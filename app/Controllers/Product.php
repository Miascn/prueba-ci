<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }

    public function index()
    {
        $data['titulo']    = 'Productos';
        $data['productos'] = $this->model->orderBy('id', 'DESC')->findAll();

        return view('products/index', $data);
    }

    public function crear()
    {
        $data['titulo']   = 'Nuevo Producto';
        $data['producto'] = null;
        $data['accion']   = 'crear';

        return view('products/form', $data);
    }

    public function guardar()
    {
        $this->model->save([
            'codigo'      => strtoupper(trim($this->request->getPost('codigo') ?? '')),
            'nombre'      => $this->request->getPost('nombre'),
            'precio'      => $this->request->getPost('precio'),
            'stock'       => $this->request->getPost('stock'),
            'descripcion' => $this->request->getPost('descripcion'),
        ]);

        return redirect()->to('/productos')->with('success', 'Producto registrado con éxito.');
    }

    public function editar($id)
    {
        $data['titulo']   = 'Editar Producto';
        $data['producto'] = $this->model->find($id);
        $data['accion']   = 'editar';

        if (!$data['producto']) {
            return redirect()->to('/productos')->with('error', 'Producto no encontrado.');
        }

        return view('products/form', $data);
    }

    public function actualizar($id)
    {
        $this->model->update($id, [
            'codigo'      => strtoupper(trim($this->request->getPost('codigo') ?? '')),
            'nombre'      => $this->request->getPost('nombre'),
            'precio'      => $this->request->getPost('precio'),
            'stock'       => $this->request->getPost('stock'),
            'descripcion' => $this->request->getPost('descripcion'),
        ]);

        return redirect()->to('/productos')->with('success', 'Producto actualizado con éxito.');
    }

    public function eliminar($id)
    {
        $this->model->delete($id);
        return redirect()->to('/productos')->with('success', 'Producto eliminado con éxito.');
    }
}
