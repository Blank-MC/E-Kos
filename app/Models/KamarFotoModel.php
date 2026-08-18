<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarFotoModel extends Model
{
    protected $table            = 'kamar_foto';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['id_kamar', 'file_foto'];
    protected $useTimestamps    = true;
}
