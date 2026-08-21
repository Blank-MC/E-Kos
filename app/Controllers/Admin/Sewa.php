<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SewaModel;
use App\Models\KamarModel;
use App\Models\UserModel;

class Sewa extends BaseController
{
    public function index()
    {
        $sewaModel = new SewaModel();

        // Mengambil data sewa dan di-join dengan tabel users dan kamar
        // Pastikan nama tabel di database lu 'sewa', 'users', dan 'kamar'
        $data = [
            'title' => 'Kelola Pengajuan Sewa',
            'sewa' => $sewaModel->select('sewa.*, users.nama as nama_penghuni, kamar.nama_kamar')
                ->join('users', 'users.id = sewa.id_user')
                ->join('kamar', 'kamar.id = sewa.id_kamar')
                ->orderBy('sewa.created_at', 'DESC')
                ->findAll()
        ];

        return view('admin/sewa/index', $data);
    }

    // Fungsi untuk mengubah status (Approve / Reject)
    public function updateStatus($id, $status)
    {
        $sewaModel = new SewaModel();
        $userModel = new UserModel();
        $kamarModel = new KamarModel();

        // Cari data sewa berdasarkan ID
        $sewa = $sewaModel->find($id);

        if ($status == 'approve') {
            // 1. Ubah status sewa jadi Aktif/Berjalan
            $sewaModel->update($id, ['status' => 'Berjalan']);

            // 2. Aktifkan akun user agar bisa login
            $userModel->update($sewa['id_user'], ['is_active' => 1]);

            // 3. Ubah status kamar jadi Penuh
            $kamarModel->update($sewa['id_kamar'], ['status' => 'Penuh']);

            return redirect()->to('admin/sewa')->with('pesan', 'Pengajuan sewa disetujui! Kamar otomatis menjadi Penuh dan Akun Penghuni diaktifkan.');
        } elseif ($status == 'reject') {
            // Jika ditolak
            $sewaModel->update($id, ['status' => 'Ditolak']);
            return redirect()->to('admin/sewa')->with('error', 'Pengajuan sewa ditolak.');
        }
    }
}
