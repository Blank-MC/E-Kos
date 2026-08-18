<?php

namespace App\Models;

use CodeIgniter\Model;

class SewaModel extends Model
{
    protected $table = 'sewa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_kamar', 'id_penghuni', 'tgl_mulai', 'durasi_bulan', 'tgl_selesai', 'status', 'catatan_admin'];
    protected $useTimestamps = true;

    public function getSewaLengkap()
    {
        return $this->select('sewa.*, kamar.nama_kamar, kamar.harga_bulanan, users.nama as nama_penghuni, users.no_hp')
            ->join('kamar', 'kamar.id = sewa.id_kamar')
            ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
            ->join('users', 'users.id = penghuni.id_user')
            ->findAll();
    }
}
