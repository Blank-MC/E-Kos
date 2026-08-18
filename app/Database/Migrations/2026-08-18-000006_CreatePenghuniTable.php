<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenghuniTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_user'        => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'nik'            => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'jenis_kelamin'  => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'null' => true],
            'alamat_asal'    => ['type' => 'TEXT', 'null' => true],
            'pekerjaan'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'foto_ktp'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'kontak_darurat' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('penghuni');
    }

    public function down()
    {
        $this->forge->dropTable('penghuni');
    }
}
