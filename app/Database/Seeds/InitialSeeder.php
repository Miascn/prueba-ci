<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // 1. Usuario inicial
        $this->db->table('usuarios')->emptyTable();
        $this->db->table('usuarios')->insert([
            'nombre'     => 'Administrador del Sistema',
            'usuario'    => 'admin',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'rol'        => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Clientes iniciales
        $this->db->table('clientes')->emptyTable();
        $this->db->table('clientes')->insertBatch([
            [
                'documento'  => '05123456-7',
                'nombre'     => 'Juan Pérez Rodríguez',
                'telefono'   => '7123-4567',
                'email'      => 'juan.perez@example.com',
                'direccion'  => 'Colonia Escalón, San Salvador',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'documento'  => '06234567-8',
                'nombre'     => 'María Gómez Hernández',
                'telefono'   => '7234-5678',
                'email'      => 'maria.gomez@example.com',
                'direccion'  => 'Santa Tecla, La Libertad',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'documento'  => '07345678-9',
                'nombre'     => 'Carlos Ramos Torres',
                'telefono'   => '7345-6789',
                'email'      => 'carlos.ramos@example.com',
                'direccion'  => 'Soyapango, San Salvador',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // 3. Productos iniciales
        $this->db->table('productos')->emptyTable();
        $this->db->table('productos')->insertBatch([
            [
                'codigo'      => 'PROD-001',
                'nombre'      => 'Laptop Dell Inspiron 15',
                'descripcion' => 'Intel Core i5, 16GB RAM, 512GB SSD NVMe',
                'precio'      => 650.00,
                'stock'       => 10,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'codigo'      => 'PROD-002',
                'nombre'      => 'Mouse Inalámbrico Logitech M170',
                'descripcion' => 'Conexión 2.4GHz, batería de larga duración',
                'precio'      => 15.50,
                'stock'       => 45,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'codigo'      => 'PROD-003',
                'nombre'      => 'Teclado Mecánico RGB Redragon',
                'descripcion' => 'Switches azules, retroiluminación configurable',
                'precio'      => 45.00,
                'stock'       => 20,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'codigo'      => 'PROD-004',
                'nombre'      => 'Monitor Samsung 24" IPS 75Hz',
                'descripcion' => 'Resolución Full HD 1080p, HDMI y VGA',
                'precio'      => 130.00,
                'stock'       => 8,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'codigo'      => 'PROD-005',
                'nombre'      => 'Auriculares Gamer con Micrófono',
                'descripcion' => 'Sonido estéreo envolvente, almohadillas ergonómicas',
                'precio'      => 28.00,
                'stock'       => 15,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}
