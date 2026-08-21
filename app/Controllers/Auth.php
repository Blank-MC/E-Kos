<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return session()->get('role') === 'admin'
                ? redirect()->to('/admin/dashboard')
                : redirect()->to('/penghuni/dashboard');
        }

        $db = \Config\Database::connect();
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();

        $data = [
            'title'      => 'Login | ' . ($pengaturan['nama_kos'] ?? 'E-Kos'),
            'pengaturan' => $pengaturan
        ];

        return view('auth/login', $data);
    }

    public function processLogin()
    {
        $db = \Config\Database::connect();
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $db->table('users')->where('email', $email)->get()->getRowArray();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        // 1. Validasi Password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        // 2. Validasi Status Akun (Cek apakah sudah dinonaktifkan karena sewa selesai)
        if ($user['status'] !== 'aktif') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda sudah dinonaktifkan karena masa sewa telah selesai. Silakan hubungi admin kos.');
        }

        // 3. Set Session Login
        $sessionData = [
            'id_user'   => $user['id'],
            'nama'      => $user['nama'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true
        ];
        session()->set($sessionData);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->to('/penghuni/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('pesan', 'Anda berhasil keluar dari sistem.');
    }
}
