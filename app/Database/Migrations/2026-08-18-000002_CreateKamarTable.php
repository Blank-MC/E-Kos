<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKamarTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nama_kamar'    => ['type' => 'VARCHAR', 'constraint' => 50],
            'tipe'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'harga_bulanan' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'deskripsi'     => ['type' => 'TEXT', 'null' => true],
            'ukuran'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['kosong', 'terisi', 'maintenance'], 'default' => 'kosong'],
            'foto_utama'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kamar');
    }

    public function down()
    {
        $this->forge->dropTable('kamar');
    }
}
