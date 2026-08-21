<?php

namespace App\Controllers\Penghuni;

use App\Controllers\BaseController;

class Pengaduan extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'penghuni') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');

        // CEK STATUS AKUN
        $userCek = $db->table('users')->where('id', $id_user)->get()->getRowArray();
        if (!$userCek || $userCek['status'] !== 'aktif') {
            session()->destroy();
            return redirect()->to('/')->with('error', 'Masa sewa Anda telah selesai dan akun telah dinonaktifkan.');
        }

        $pengaturan = $db->table('pengaturan')->get()->getRowArray();
        $penghuni = $db->table('penghuni')->where('id_user', $id_user)->get()->getRowArray();
        $pengaduan = [];

        if ($penghuni) {
            $pengaduan = $db->table('pengaduan')
                ->where('id_penghuni', $penghuni['id'])
                ->orderBy('id', 'DESC')
                ->get()->getResultArray();
        }

        $data = [
            'title'      => 'Pusat Pengaduan | ' . ($pengaturan['nama_kos'] ?? 'E-Kos'),
            'pengaduan'  => $pengaduan,
            'pengaturan' => $pengaturan
        ];

        return view('penghuni/pengaduan', $data);
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'penghuni') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');

        // CEK STATUS AKUN
        $userCek = $db->table('users')->where('id', $id_user)->get()->getRowArray();
        if (!$userCek || $userCek['status'] !== 'aktif') {
            session()->destroy();
            return redirect()->to('/')->with('error', 'Masa sewa Anda telah selesai dan akun telah dinonaktifkan.');
        }

        $penghuni = $db->table('penghuni')->where('id_user', $id_user)->get()->getRowArray();

        if (!$penghuni) {
            return redirect()->back()->with('error', 'Data penghuni tidak ditemukan.');
        }

        $db->table('pengaduan')->insert([
            'id_penghuni' => $penghuni['id'],
            'judul'       => $this->request->getPost('judul'),
            'isi'         => $this->request->getPost('isi'),
            'status'      => 'baru'
        ]);

        return redirect()->back()->with('pesan', 'Pengaduan berhasil dikirim ke Admin.');
    }
}
