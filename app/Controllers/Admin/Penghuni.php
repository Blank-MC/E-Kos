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
    public function updateAkun($id_user)
    {
        $db = \Config\Database::connect();

        $email    = $this->request->getPost('email');
        $no_hp    = $this->request->getPost('no_hp');
        $status   = $this->request->getPost('status');
        $password = $this->request->getPost('password');

        // Cek jika email diganti, pastikan tidak bentrok dengan user lain
        $cekEmail = $db->table('users')
            ->where('email', $email)
            ->where('id !=', $id_user)
            ->get()->getRowArray();

        if ($cekEmail) {
            return redirect()->back()->with('error', 'Gagal update: Email tersebut sudah digunakan oleh akun lain.');
        }

        $updateData = [
            'email'  => $email,
            'no_hp'  => $no_hp,
            'status' => $status
        ];

        // Jika form password baru diisi, enkripsi dan simpan
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $db->table('users')->where('id', $id_user)->update($updateData);

        return redirect()->to('admin/penghuni')->with('pesan', 'Data akun & password penghuni berhasil diperbarui!');
    }
}
