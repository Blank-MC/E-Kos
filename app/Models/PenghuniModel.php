<?php

namespace App\Models;

use CodeIgniter\Model;

class PenghuniModel extends Model
{
    protected $table            = 'penghuni';
    protected $primaryKey       = 'id';

    // Kolom yang ada di tabel penghuni
    protected $allowedFields    = [
        'id_user',
        'nik',
        'jenis_kelamin',
        'alamat_asal',
        'pekerjaan',
        'foto_ktp',
        'kontak_darurat'
    ];

    protected $useTimestamps    = true;

    // Fungsi sakti buat gabungin tabel penghuni dan users[cite: 1]
    public function getPenghuniLengkap()
    {
        return $this->select('penghuni.*, users.nama, users.email, users.no_hp, users.status, users.foto_profil')
            ->join('users', 'users.id = penghuni.id_user')
            ->findAll();
    }
}
