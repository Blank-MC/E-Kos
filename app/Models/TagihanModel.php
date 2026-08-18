<?php

namespace App\Models;

use CodeIgniter\Model;

class TagihanModel extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_sewa', 'periode_bulan', 'jumlah', 'tgl_jatuh_tempo', 'status'];
    protected $useTimestamps = true;

    public function getTagihanLengkap()
    {
        return $this->select('tagihan.*, kamar.nama_kamar, users.nama as nama_penghuni')
            ->join('sewa', 'sewa.id = tagihan.id_sewa')
            ->join('kamar', 'kamar.id = sewa.id_kamar')
            ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
            ->join('users', 'users.id = penghuni.id_user')
            ->findAll();
    }
}
