<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $usuario  = trim($this->request->getPost('usuario') ?? '');
        $password = $this->request->getPost('password') ?? '';

        $userModel = new UserModel();
        $user = $userModel->where('usuario', $usuario)->first();

        // Validar credenciales y contraseña con hash
        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id'     => $user['id'],
                'user_nombre' => $user['nombre'],
                'user_alias'  => $user['usuario'],
                'logged_in'   => true,
            ]);

            return redirect()->to('/')->with('success', '¡Bienvenido(a), ' . esc($user['nombre']) . '!');
        }

        return redirect()->back()->withInput()->with('error', 'Usuario o contraseña incorrectos.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Has cerrado sesión.');
    }
}
