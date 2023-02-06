<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'read-module' => 'hanya untuk membaca',
            'create-module' => 'akses untuk membuat modele',
            'delete-module' => 'akses untuk delete modele',
            'update-module' => 'akses untuk update modele',
        ];

        foreach ($data as $key => $value) {
            db_connect()->table('auth_permissions')->insert(['name' => $key, 'description' => $value]);
        }
    }
}
