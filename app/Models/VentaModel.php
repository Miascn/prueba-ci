<?php

namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table            = 'ventas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'numero_factura',
        'cliente_id',
        'usuario_id',
        'total',
        'fecha',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Obtiene el listado de ventas uniendo cliente y usuario vendedor
     */
    public function getVentasConRelaciones()
    {
        return $this->select('ventas.*, clientes.nombre as cliente_nombre, clientes.documento as cliente_documento, usuarios.nombre as usuario_nombre')
                    ->join('clientes', 'clientes.id = ventas.cliente_id', 'left')
                    ->join('usuarios', 'usuarios.id = ventas.usuario_id', 'left')
                    ->orderBy('ventas.id', 'DESC')
                    ->findAll();
    }

    /**
     * Obtiene una venta específica con datos del cliente y usuario
     */
    public function getVentaPorId($id)
    {
        return $this->select('ventas.*, clientes.nombre as cliente_nombre, clientes.documento as cliente_documento, clientes.telefono as cliente_telefono, clientes.email as cliente_email, clientes.direccion as cliente_direccion, usuarios.nombre as usuario_nombre')
                    ->join('clientes', 'clientes.id = ventas.cliente_id', 'left')
                    ->join('usuarios', 'usuarios.id = ventas.usuario_id', 'left')
                    ->where('ventas.id', $id)
                    ->first();
    }
}
