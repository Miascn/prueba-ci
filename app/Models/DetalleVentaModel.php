<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleVentaModel extends Model
{
    protected $table            = 'detalle_ventas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    /**
     * Obtiene los productos correspondientes a una venta
     */
    public function getDetallesPorVenta($ventaId)
    {
        return $this->select('detalle_ventas.*, productos.codigo as producto_codigo, productos.nombre as producto_nombre')
                    ->join('productos', 'productos.id = detalle_ventas.producto_id', 'left')
                    ->where('detalle_ventas.venta_id', $ventaId)
                    ->findAll();
    }
}
