<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenghuniModel;

class Penghuni extends BaseController
{
    protected $penghuniModel;
    protected $db;

    public function __construct()
    {
        $this->penghuniModel = new PenghuniModel();
        $this->db = \Config\Database::connect(); // Panggil koneksi DB manual buat hapus user
    }

    // Tampilkan daftar penghuni
    public function index()
    {
        $data = [
            'title'    => 'Data Penghuni Kos | E-Kos',
            'penghuni' => $this->penghuniModel->getPenghuniLengkap()
        ];

        return view('admin/penghuni/index', $data);
    }

    // Eksekusi hapus penghuni beserta akunnya
    public function delete($id)
    {
        // Cari data penghuni berdasarkan ID untuk mendapatkan id_user[cite: 1]
        $penghuni = $this->penghuniModel->find($id);

        if ($penghuni) {
            // Hapus dari tabel users (Otomatis data di tabel penghuni ikut terhapus karena CASCADE)[cite: 1]
            $this->db->table('users')->where('id', $penghuni['id_user'])->delete();
        }

        return redirect()->to('/admin/penghuni')->with('pesan', 'Data penghuni dan akunnya berhasil dihapus.');
    }
}
