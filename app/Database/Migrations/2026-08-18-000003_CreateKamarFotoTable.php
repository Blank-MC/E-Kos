<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKamarFotoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_kamar'   => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'file_foto'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kamar', 'kamar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kamar_foto');
    }

    public function down()
    {
        $this->forge->dropTable('kamar_foto');
    }
}
