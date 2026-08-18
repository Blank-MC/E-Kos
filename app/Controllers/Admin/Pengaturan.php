<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengaturanModel;

class Pengaturan extends BaseController
{
    protected $pengaturanModel;

    public function __construct()
    {
        $this->pengaturanModel = new PengaturanModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Pengaturan Profil Kos | E-Kos',
            'pengaturan' => $this->pengaturanModel->first() // Ambil baris pertama profil kos
        ];
        return view('admin/pengaturan/index', $data);
    }

    public function update($id)
    {
        $this->pengaturanModel->update($id, [
            'nama_kos'  => $this->request->getPost('nama_kos'),
            'alamat'    => $this->request->getPost('alamat'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'email'     => $this->request->getPost('email'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ]);
        return redirect()->to('/admin/pengaturan')->with('pesan', 'Pengaturan kos berhasil diperbarui.');
    }
}
