<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // Si ya está autenticado, redirigir al inicio
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $usuario = trim($this->request->getPost('usuario') ?? '');
        $password = $this->request->getPost('password') ?? '';

        if (empty($usuario) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Por favor complete todos los campos.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('usuario', $usuario)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Usuario o contraseña incorrectos.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Usuario o contraseña incorrectos.');
        }

        // Iniciar sesión
        session()->set([
            'user_id'     => $user['id'],
            'user_nombre' => $user['nombre'],
            'user_alias'  => $user['usuario'],
            'user_rol'    => $user['rol'],
            'logged_in'   => true,
        ]);

        return redirect()->to('/')->with('success', '¡Bienvenido(a), ' . esc($user['nombre']) . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Has cerrado sesión correctamente.');
    }
}
