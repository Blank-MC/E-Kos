<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaduanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_penghuni'    => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'isi'            => ['type' => 'TEXT'],
            'status'         => ['type' => 'ENUM', 'constraint' => ['baru', 'diproses', 'selesai'], 'default' => 'baru'],
            'balasan_admin'  => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penghuni', 'penghuni', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengaduan');
    }

    public function down()
    {
        $this->forge->dropTable('pengaduan');
    }
}
