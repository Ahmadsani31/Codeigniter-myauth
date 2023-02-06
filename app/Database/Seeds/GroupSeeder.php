<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $group = new GroupModel();
        $permissions = new PermissionModel();

        $group->insert([
            'name' => 'administrator',
            'description' => 'administrator kelola utama website'
        ]);

        $group->insert([
            'name' => 'dosen',
            'description' => 'hanya bisa diakses oleh dosen'
        ]);

        $group->insert([
            'name' => 'mahasiswa',
            'description' => 'hanya bisa diakses oleh mahasiswa'
        ]);


        foreach ($permissions->findAll() as $key) {
            $group->addPermissionToGroup($key->id, $group->getInsertId());
        }

        $dosen = $permissions->where(['name' => 'read-module'])->findAll();
        foreach ($dosen as $dosenPermis) {
            $group->addPermissionToGroup($dosenPermis->id, $group->getInsertId());
        }
    }
}
