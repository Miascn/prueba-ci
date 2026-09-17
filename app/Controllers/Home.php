<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ProductModel;
use App\Models\VentaModel;

class Home extends BaseController
{
    public function index(): string
    {
        $clienteModel = new ClienteModel();
        $productModel = new ProductModel();
        $ventaModel   = new VentaModel();

        $totalClientes  = $clienteModel->countAllResults();
        $totalProductos = $productModel->countAllResults();
        $productosBajoStock = $productModel->where('stock <=', 5)->countAllResults();
        $totalVentas    = $ventaModel->countAllResults();
        
        $sumaTotal = $ventaModel->selectSum('total')->first();
        $ingresosTotales = $sumaTotal['total'] ?? 0.00;

        $ultimasVentas = $ventaModel->select('ventas.*, clientes.nombre as cliente_nombre')
                                   ->join('clientes', 'clientes.id = ventas.cliente_id', 'left')
                                   ->orderBy('ventas.id', 'DESC')
                                   ->findAll(5);

        $data = [
            'titulo'             => 'Panel Principal',
            'totalClientes'      => $totalClientes,
            'totalProductos'     => $totalProductos,
            'productosBajoStock' => $productosBajoStock,
            'totalVentas'        => $totalVentas,
            'ingresosTotales'    => $ingresosTotales,
            'ultimasVentas'      => $ultimasVentas,
        ];

        return view('home/dashboard', $data);
    }
}
