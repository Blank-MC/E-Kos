<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarModel extends Model
{
    protected $table            = 'kamar';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nama_kamar',
        'tipe',
        'harga_bulanan',
        'deskripsi',
        'ukuran',
        'status',
        'foto_utama'
    ];
    // Otomatis isi created_at & updated_at sesuai skema DB
    protected $useTimestamps    = true;
}
