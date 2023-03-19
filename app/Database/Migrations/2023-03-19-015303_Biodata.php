<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Biodata extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'BiodataID'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'UserID'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'NoHP'                  => ['type' => 'varchar', 'constraint' => 15],
            'TentangSaya'           => ['type' => 'text'],
            'ProvinsiID'            => ['type' => 'varchar', 'constraint' => 10],
            'KabutapenID'           => ['type' => 'varchar', 'constraint' => 10],
            'KecamatanID'           => ['type' => 'varchar', 'constraint' => 10],
            'Avatar'                => ['type' => 'text'],
            'Alamat'                => ['type' => 'text'],
            'Created_AT'            => ['type' => 'datetime'],
            'UCreate'               => ['type' => 'varchar', 'constraint' => 100],
            'Updated_AT'            => ['type' => 'datetime'],
            'UEdited'               => ['type' => 'varchar', 'constraint' => 100],
            'Deleted_AT'            => ['type' => 'datetime'],
        ]);
        $this->forge->addKey('BiodataID', true);
        $this->forge->addForeignKey('UserID', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('biodatas', true);
    }

    public function down()
    {
        $this->forge->dropTable('biodatas');
    }
}
