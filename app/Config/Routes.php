<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Rutas Públicas (Autenticación)
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// Rutas Protegidas por Filtro 'auth'
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Dashboard
    $routes->get('/', 'Home::index');

    // Clientes
    $routes->group('clientes', static function ($routes) {
        $routes->get('', 'Clientes::index');
        $routes->get('crear', 'Clientes::crear');
        $routes->post('guardar', 'Clientes::guardar');
        $routes->get('editar/(:num)', 'Clientes::editar/$1');
        $routes->post('actualizar/(:num)', 'Clientes::actualizar/$1');
        $routes->get('eliminar/(:num)', 'Clientes::eliminar/$1');
    });

    // Productos
    $routes->group('productos', static function ($routes) {
        $routes->get('', 'Product::index');
        $routes->get('crear', 'Product::crear');
        $routes->post('guardar', 'Product::guardar');
        $routes->get('editar/(:num)', 'Product::editar/$1');
        $routes->post('actualizar/(:num)', 'Product::actualizar/$1');
        $routes->get('eliminar/(:num)', 'Product::eliminar/$1');
    });

    // Ventas
    $routes->group('ventas', static function ($routes) {
        $routes->get('', 'Ventas::index');
        $routes->get('crear', 'Ventas::crear');
        $routes->post('guardar', 'Ventas::guardar');
        $routes->get('detalle/(:num)', 'Ventas::detalle/$1');
        $routes->get('eliminar/(:num)', 'Ventas::eliminar/$1');
    });
});
