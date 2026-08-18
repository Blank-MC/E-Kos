<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagihanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_sewa'         => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'periode_bulan'   => ['type' => 'VARCHAR', 'constraint' => 20],
            'jumlah'          => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'tgl_jatuh_tempo' => ['type' => 'DATE'],
            'status'          => ['type' => 'ENUM', 'constraint' => ['belum_bayar', 'menunggu_konfirmasi', 'lunas', 'terlambat'], 'default' => 'belum_bayar'],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_sewa', 'sewa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tagihan');
    }

    public function down()
    {
        $this->forge->dropTable('tagihan');
    }
}
