<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'documento',
        'nombre',
        'telefono',
        'email',
        'direccion',
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
        'nombre' => 'required|min_length[3]|max_length[150]',
        'email'  => 'permit_empty|valid_email|max_length[150]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre del cliente es obligatorio.',
        ],
        'email' => [
            'valid_email' => 'Ingrese un correo electrónico válido.',
        ],
    ];
}
