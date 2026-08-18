<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaturanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nama_kos'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'alamat'      => ['type' => 'TEXT', 'null' => true],
            'no_telp'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'peraturan'   => ['type' => 'TEXT', 'null' => true],
            'latitude'    => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'longitude'   => ['type' => 'DECIMAL', 'constraint' => '10,7', 'null' => true],
            'logo'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengaturan');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan');
    }
}
