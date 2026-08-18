<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FasilitasModel;

class Fasilitas extends BaseController
{
    protected $fasilitasModel;

    public function __construct()
    {
        $this->fasilitasModel = new FasilitasModel();
    }

    // Nampilin form tambah sekaligus tabel data
    public function index()
    {
        $data = [
            'title'     => 'Data Fasilitas | E-Kos',
            'fasilitas' => $this->fasilitasModel->findAll()
        ];
        return view('admin/fasilitas/index', $data); // Arahkan ke folder fasilitas
    }

    // Eksekusi simpan data baru
    public function store()
    {
        $this->fasilitasModel->save([
            'nama_fasilitas' => $this->request->getPost('nama_fasilitas'),
            'icon'           => $this->request->getPost('icon')
        ]);

        return redirect()->to('/admin/fasilitas')->with('pesan', 'Fasilitas baru berhasil ditambahkan.');
    }

    // Eksekusi update data
    public function update($id)
    {
        $this->fasilitasModel->save([
            'id'             => $id,
            'nama_fasilitas' => $this->request->getPost('nama_fasilitas'),
            'icon'           => $this->request->getPost('icon')
        ]);

        return redirect()->to('/admin/fasilitas')->with('pesan', 'Data fasilitas berhasil diupdate.');
    }

    // Eksekusi hapus data
    public function delete($id)
    {
        $this->fasilitasModel->delete($id);
        return redirect()->to('/admin/fasilitas')->with('pesan', 'Fasilitas berhasil dihapus.');
    }
}
