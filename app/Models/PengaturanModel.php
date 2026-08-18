<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kos', 'alamat', 'no_telp', 'email', 'deskripsi'];
}
