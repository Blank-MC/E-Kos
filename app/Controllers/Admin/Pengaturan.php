<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pengaturan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil data pengaturan baris pertama
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();

        // Jika tabel pengaturan masih kosong, insert data default otomatis
        if (!$pengaturan) {
            $db->table('pengaturan')->insert([
                'nama_kos'  => 'E-Kos Indonesia',
                'no_telp'   => '081234567890',
                'email'     => 'admin@ekos.com',
                'alamat'    => 'Alamat Kos Belum Diisi',
                'deskripsi' => 'Deskripsi kos belum diisi.'
            ]);
            // Ambil ulang data setelah di-insert
            $pengaturan = $db->table('pengaturan')->get()->getRowArray();
        }

        $data = [
            'title'      => 'Pengaturan Kos',
            'pengaturan' => $pengaturan
        ];

        return view('admin/pengaturan/index', $data);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();

        $db->table('pengaturan')->where('id', $id)->update([
            'nama_kos'  => $this->request->getPost('nama_kos'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'email'     => $this->request->getPost('email'),
            'alamat'    => $this->request->getPost('alamat'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('admin/pengaturan')->with('pesan', 'Pengaturan kos berhasil diperbarui!');
    }
}
