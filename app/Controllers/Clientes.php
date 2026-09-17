<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;

class Clientes extends BaseController
{
    protected $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    public function index()
    {
        $data = [
            'titulo'   => 'Gestión de Clientes',
            'clientes' => $this->clienteModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('clientes/index', $data);
    }

    public function crear()
    {
        $data = [
            'titulo'  => 'Registrar Nuevo Cliente',
            'cliente' => null,
            'accion'  => 'crear',
        ];

        return view('clientes/form', $data);
    }

    public function guardar()
    {
        $reglas = [
            'nombre' => 'required|min_length[3]|max_length[150]',
            'email'  => 'permit_empty|valid_email|max_length[150]',
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->clienteModel->save([
            'documento' => trim($this->request->getPost('documento') ?? ''),
            'nombre'    => trim($this->request->getPost('nombre') ?? ''),
            'telefono'  => trim($this->request->getPost('telefono') ?? ''),
            'email'     => trim($this->request->getPost('email') ?? ''),
            'direccion' => trim($this->request->getPost('direccion') ?? ''),
        ]);

        return redirect()->to('/clientes')->with('success', 'Cliente registrado exitosamente.');
    }

    public function editar($id = null)
    {
        $cliente = $this->clienteModel->find($id);

        if (!$cliente) {
            return redirect()->to('/clientes')->with('error', 'El cliente solicitado no existe.');
        }

        $data = [
            'titulo'  => 'Editar Cliente',
            'cliente' => $cliente,
            'accion'  => 'editar',
        ];

        return view('clientes/form', $data);
    }

    public function actualizar($id = null)
    {
        $cliente = $this->clienteModel->find($id);

        if (!$cliente) {
            return redirect()->to('/clientes')->with('error', 'El cliente solicitado no existe.');
        }

        $reglas = [
            'nombre' => 'required|min_length[3]|max_length[150]',
            'email'  => 'permit_empty|valid_email|max_length[150]',
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->clienteModel->update($id, [
            'documento' => trim($this->request->getPost('documento') ?? ''),
            'nombre'    => trim($this->request->getPost('nombre') ?? ''),
            'telefono'  => trim($this->request->getPost('telefono') ?? ''),
            'email'     => trim($this->request->getPost('email') ?? ''),
            'direccion' => trim($this->request->getPost('direccion') ?? ''),
        ]);

        return redirect()->to('/clientes')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function eliminar($id = null)
    {
        $cliente = $this->clienteModel->find($id);

        if (!$cliente) {
            return redirect()->to('/clientes')->with('error', 'El cliente no existe.');
        }

        $this->clienteModel->delete($id);

        return redirect()->to('/clientes')->with('success', 'Cliente eliminado correctamente.');
    }
}
