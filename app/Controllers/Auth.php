<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, lempar sesuai role-nya
        if (session()->get('logged_in')) {
            if (session()->get('role') == 'admin') {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/penghuni/dashboard'); // Nanti kita buat rutenya
            }
        }

        $data = [
            'title' => 'Masuk Akun | E-Kos'
        ];
        return view('auth/login', $data);
    }

    public function proses_login()
    {
        $db = \Config\Database::connect();

        // 1. Ambil Email bukan Username
        $email = $this->request->getPost('username'); // name input di view bebas, tapi nilainya email
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $db->table('users')->where('email', $email)->get()->getRowArray();

        if ($user) {
            if (password_verify($password, $user['password'])) {

                // 2. Sesuaikan pengecekan status
                if ($user['status'] == 'nonaktif') {
                    return redirect()->back()->with('error', 'Akun Anda belum diaktifkan atau masih menunggu konfirmasi.');
                }

                $sessionData = [
                    'id_user'       => $user['id'],
                    'nama'          => $user['nama'],
                    'email'         => $user['email'],
                    'role'          => $user['role'],
                    'logged_in'     => true
                ];
                session()->set($sessionData);

                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin')->with('pesan', 'Selamat datang kembali, Admin!');
                } else {
                    return redirect()->to('/penghuni/dashboard')->with('pesan', 'Halo ' . $user['nama'] . ', selamat datang!');
                }
            } else {
                return redirect()->back()->with('error', 'Password yang Anda masukkan salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Email tidak ditemukan!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('pesan', 'Anda telah berhasil keluar.');
    }
}
