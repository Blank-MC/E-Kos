<?php

namespace App\Models;

use CodeIgniter\Model;

class FasilitasModel extends Model
{
    protected $table            = 'fasilitas';
    protected $primaryKey       = 'id';

    // Kolom yang diizinkan untuk diisi sesuai ekos_db.sql
    protected $allowedFields    = ['nama_fasilitas', 'icon'];

    // Matikan timestamps karena tabel ini murni master data
    protected $useTimestamps    = false;
}
