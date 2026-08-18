<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKamarFasilitasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_kamar'     => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'id_fasilitas' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kamar', 'kamar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_fasilitas', 'fasilitas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kamar_fasilitas');
    }

    public function down()
    {
        $this->forge->dropTable('kamar_fasilitas');
    }
}
