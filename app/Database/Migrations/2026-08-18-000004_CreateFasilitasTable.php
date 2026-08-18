<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFasilitasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nama_fasilitas' => ['type' => 'VARCHAR', 'constraint' => 50],
            'icon'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('fasilitas');
    }

    public function down()
    {
        $this->forge->dropTable('fasilitas');
    }
}
