<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pengaduan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil data pengaduan yang berelasi dengan penghuni, user, dan kamar
        $pengaduan = $db->table('pengaduan')
            ->select('pengaduan.*, users.nama as nama_penghuni, users.no_hp, kamar.nama_kamar')
            ->join('penghuni', 'penghuni.id = pengaduan.id_penghuni')
            ->join('users', 'users.id = penghuni.id_user')
            ->join('sewa', 'sewa.id_penghuni = penghuni.id AND sewa.status = "aktif"', 'left')
            ->join('kamar', 'kamar.id = sewa.id_kamar', 'left')
            ->orderBy('pengaduan.id', 'DESC')
            ->get()->getResultArray();

        $data = [
            'title'     => 'Data Pengaduan | Panel Admin',
            'pengaduan' => $pengaduan
        ];

        return view('admin/pengaduan/index', $data);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();

        $status = $this->request->getPost('status');
        $balasan_admin = $this->request->getPost('balasan_admin');

        $db->table('pengaduan')->where('id', $id)->update([
            'status'        => $status,
            'balasan_admin' => $balasan_admin
        ]);

        return redirect()->to('admin/pengaduan')->with('pesan', 'Respon pengaduan berhasil diperbarui!');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('pengaduan')->where('id', $id)->delete();

        return redirect()->to('admin/pengaduan')->with('pesan', 'Pengaduan berhasil dihapus.');
    }
}
