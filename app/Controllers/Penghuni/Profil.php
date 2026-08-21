<?php

namespace App\Controllers\Penghuni;

use App\Controllers\BaseController;

class Profil extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'penghuni') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();

        $profil = $db->table('users')
            ->select('users.*, penghuni.nik, penghuni.jenis_kelamin, penghuni.alamat_asal, penghuni.pekerjaan, penghuni.foto_ktp, penghuni.kontak_darurat')
            ->join('penghuni', 'penghuni.id_user = users.id', 'left')
            ->where('users.id', $id_user)
            ->get()->getRowArray();

        $data = [
            'title'      => 'Profil Saya | ' . ($pengaturan['nama_kos'] ?? 'E-Kos'),
            'profil'     => $profil,
            'pengaturan' => $pengaturan
        ];

        return view('penghuni/profil', $data);
    }

    public function update()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'penghuni') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');

        $nama           = $this->request->getPost('nama');
        $no_hp          = $this->request->getPost('no_hp');
        $nik            = $this->request->getPost('nik');
        $jenis_kelamin  = $this->request->getPost('jenis_kelamin');
        $alamat_asal    = $this->request->getPost('alamat_asal');
        $pekerjaan      = $this->request->getPost('pekerjaan');
        $kontak_darurat = $this->request->getPost('kontak_darurat');

        // Input Password
        $password_lama = $this->request->getPost('password_lama');
        $password_baru = $this->request->getPost('password_baru');

        // Data Update Users
        $updateUser = [
            'nama'  => $nama,
            'no_hp' => $no_hp,
        ];

        // Validasi Ganti Password jika diisi
        if (!empty($password_baru)) {
            $userCurrent = $db->table('users')->where('id', $id_user)->get()->getRowArray();

            if (empty($password_lama) || !password_verify($password_lama, $userCurrent['password'])) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai!');
            }

            if (strlen($password_baru) < 6) {
                return redirect()->back()->with('error', 'Password baru minimal harus 6 karakter.');
            }

            $updateUser['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        // Handle Foto Profil
        $fileProfil = $this->request->getFile('foto_profil');
        $namaFotoProfil = $this->request->getPost('foto_profil_lama');
        if ($fileProfil && $fileProfil->isValid() && !$fileProfil->hasMoved()) {
            $namaFotoProfil = $fileProfil->getRandomName();
            $fileProfil->move('uploads/profil/', $namaFotoProfil);
            $updateUser['foto_profil'] = $namaFotoProfil;
        }

        // Handle Foto KTP
        $fileKtp = $this->request->getFile('foto_ktp');
        $namaFotoKtp = $this->request->getPost('foto_ktp_lama');
        if ($fileKtp && $fileKtp->isValid() && !$fileKtp->hasMoved()) {
            $namaFotoKtp = $fileKtp->getRandomName();
            $fileKtp->move('uploads/ktp/', $namaFotoKtp);
        }

        $db->transStart();

        $db->table('users')->where('id', $id_user)->update($updateUser);

        $db->table('penghuni')->where('id_user', $id_user)->update([
            'nik'            => $nik,
            'jenis_kelamin'  => $jenis_kelamin,
            'alamat_asal'    => $alamat_asal,
            'pekerjaan'      => $pekerjaan,
            'kontak_darurat' => $kontak_darurat,
            'foto_ktp'       => $namaFotoKtp
        ]);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil.');
        }

        session()->set('nama', $nama);

        return redirect()->back()->with('pesan', 'Profil dan kata sandi berhasil diperbarui!');
    }
}
