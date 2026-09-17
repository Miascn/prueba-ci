<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'productos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'stock',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'codigo' => 'required|min_length[2]|max_length[50]|is_unique[productos.codigo,id,{id}]',
        'nombre' => 'required|min_length[2]|max_length[150]',
        'precio' => 'required|numeric|greater_than_equal_to[0]',
        'stock'  => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'codigo' => [
            'required'  => 'El código del producto es obligatorio.',
            'is_unique' => 'Ya existe un producto registrado con este código.',
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
}
