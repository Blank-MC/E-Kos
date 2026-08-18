<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_tagihan'        => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'tgl_bayar'         => ['type' => 'DATE'],
            'metode'            => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'transfer'],
            'bukti_transfer'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'dikonfirmasi_oleh' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'null' => true],
            'tgl_konfirmasi'    => ['type' => 'DATETIME', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_tagihan', 'tagihan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dikonfirmasi_oleh', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
}
