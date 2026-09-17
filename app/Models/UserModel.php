<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre',
        'usuario',
        'password',
        'rol',
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
        'nombre'   => 'required|min_length[3]|max_length[100]',
        'usuario'  => 'required|min_length[3]|max_length[50]|is_unique[usuarios.usuario,id,{id}]',
        'password' => 'required|min_length[5]',
    ];

    protected $validationMessages = [
        'usuario' => [
            'is_unique' => 'El nombre de usuario ya está registrado.',
        ],
    ];
}
