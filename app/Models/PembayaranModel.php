<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'pembayaran';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_tagihan',
        'tgl_bayar',
        'metode',
        'bukti_transfer',
        'dikonfirmasi_oleh',
        'tgl_konfirmasi'
    ];
    protected $useTimestamps    = true;
}
