<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Sewa extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Mengambil data dari 5 tabel sekaligus pakai Query Builder (Sewa, Penghuni, Users, Kamar, Tagihan, Pembayaran)
        $sewa = $db->table('sewa')
            ->select('sewa.id, sewa.tgl_mulai as tanggal_masuk, sewa.durasi_bulan as durasi_sewa, sewa.status, 
                      users.nama as nama_penghuni, kamar.nama_kamar, 
                      tagihan.id as id_tagihan, tagihan.jumlah as total_tagihan, 
                      pembayaran.bukti_transfer as bukti_bayar')
            ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
            ->join('users', 'users.id = penghuni.id_user')
            ->join('kamar', 'kamar.id = sewa.id_kamar')
            ->join('tagihan', 'tagihan.id_sewa = sewa.id', 'left')
            ->join('pembayaran', 'pembayaran.id_tagihan = tagihan.id', 'left')
            ->orderBy('sewa.created_at', 'DESC')
            ->get()->getResultArray();

        $data = [
            'title' => 'Kelola Pengajuan Sewa',
            'sewa' => $sewa
        ];

        return view('admin/sewa/index', $data);
    }

    // Fungsi untuk mengubah status (Approve / Reject)
    public function updateStatus($id, $status)
    {
        $db = \Config\Database::connect();
        $id_admin = session()->get('id_user');

        // Cari data sewa beserta relasinya untuk di-update
        $sewa = $db->table('sewa')
            ->select('sewa.*, penghuni.id_user as id_user_login, tagihan.id as id_tagihan')
            ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
            ->join('tagihan', 'tagihan.id_sewa = sewa.id', 'left')
            ->where('sewa.id', $id)
            ->get()->getRowArray();

        if (!$sewa) {
            return redirect()->to('admin/sewa')->with('error', 'Data sewa tidak ditemukan.');
        }

        if ($status == 'approve') {
            // --- MULAI TRANSAKSI ---
            $db->transStart();

            // 1. Ubah status sewa jadi 'aktif'
            $db->table('sewa')->where('id', $id)->update(['status' => 'aktif']);

            // 2. Aktifkan akun user agar bisa login (status = 'aktif')
            $db->table('users')->where('id', $sewa['id_user_login'])->update(['status' => 'aktif']);

            // 3. Ubah status kamar jadi 'terisi'
            $db->table('kamar')->where('id', $sewa['id_kamar'])->update(['status' => 'terisi']);

            // 4. Ubah status tagihan jadi 'lunas' dan set siapa admin yang konfirmasi
            if ($sewa['id_tagihan']) {
                $db->table('tagihan')->where('id', $sewa['id_tagihan'])->update(['status' => 'lunas']);
                $db->table('pembayaran')->where('id_tagihan', $sewa['id_tagihan'])->update([
                    'dikonfirmasi_oleh' => $id_admin,
                    'tgl_konfirmasi' => date('Y-m-d H:i:s')
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->to('admin/sewa')->with('error', 'Gagal menyetujui pengajuan karena kesalahan sistem.');
            }

            return redirect()->to('admin/sewa')->with('pesan', 'Pengajuan disetujui! Kamar otomatis Terisi dan Akun Penghuni diaktifkan.');
        } elseif ($status == 'reject') {
            // Jika ditolak, ubah status sewa jadi 'ditolak'
            $db->table('sewa')->where('id', $id)->update(['status' => 'ditolak']);
            return redirect()->to('admin/sewa')->with('error', 'Pengajuan sewa ditolak.');
        }
    }
}
