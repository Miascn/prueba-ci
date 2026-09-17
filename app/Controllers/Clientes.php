<?php

namespace App\Controllers;

use App\Models\ClienteModel;

class Clientes extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ClienteModel();
    }

    public function index()
    {
        $data['titulo']   = 'Clientes';
        $data['clientes'] = $this->model->orderBy('id', 'DESC')->findAll();

        return view('clientes/index', $data);
    }

    public function crear()
    {
        $data['titulo']  = 'Nuevo Cliente';
        $data['cliente'] = null;
        $data['accion']  = 'crear';

        return view('clientes/form', $data);
    }

    public function guardar()
    {
        $this->model->save([
            'nombre'    => $this->request->getPost('nombre'),
            'documento' => $this->request->getPost('documento'),
            'telefono'  => $this->request->getPost('telefono'),
            'email'     => $this->request->getPost('email'),
            'direccion' => $this->request->getPost('direccion'),
        ]);

        return redirect()->to('/clientes')->with('success', 'Cliente registrado con éxito.');
    }

    public function editar($id)
    {
        $data['titulo']  = 'Editar Cliente';
        $data['cliente'] = $this->model->find($id);
        $data['accion']  = 'editar';

        if (!$data['cliente']) {
            return redirect()->to('/clientes')->with('error', 'Cliente no encontrado.');
        }

        return view('clientes/form', $data);
    }

    public function actualizar($id)
    {
        $this->model->update($id, [
            'nombre'    => $this->request->getPost('nombre'),
            'documento' => $this->request->getPost('documento'),
            'telefono'  => $this->request->getPost('telefono'),
            'email'     => $this->request->getPost('email'),
            'direccion' => $this->request->getPost('direccion'),
        ]);

        return redirect()->to('/clientes')->with('success', 'Cliente actualizado con éxito.');
    }

    public function eliminar($id)
    {
        $this->model->delete($id);
        return redirect()->to('/clientes')->with('success', 'Cliente eliminado con éxito.');
    }
}
