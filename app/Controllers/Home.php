<?php

namespace App\Controllers;

use App\Models\KamarModel;

class Home extends BaseController
{
    public function index()
    {
        $kamarModel = new KamarModel();

        $data = [
            'title' => 'E-Kos | Hunian Nyaman Seperti Di Rumah',
            'kamar' => $kamarModel->findAll()
        ];

        return view('guest/home', $data);
    }

    // FUNGSI BARU UNTUK DETAIL KAMAR
    public function detail($id)
    {
        $kamarModel = new KamarModel();
        $kamar = $kamarModel->find($id);

        // Jika ID kamar tidak ada di database, lemparkan error 404
        if (!$kamar) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kamar tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Kamar | ' . $kamar['nama_kamar'],
            'kamar' => $kamar
        ];

        return view('guest/detail', $data);
    }

    // FUNGSI UNTUK MENAMPILKAN FORM PESAN & REGISTRASI
    public function pesan($id)
    {
        $kamarModel = new \App\Models\KamarModel();
        $kamar = $kamarModel->find($id);

        // Validasi: Kalau kamar gak ada atau statusnya penuh, lempar balik ke beranda
        if (!$kamar || $kamar['status'] != 'Tersedia') {
            return redirect()->to('/')->with('error', 'Maaf, kamar tersebut tidak tersedia atau sudah penuh.');
        }

        $data = [
            'title' => 'Form Pemesanan & Registrasi | E-Kos',
            'kamar' => $kamar
        ];

        return view('guest/pesan', $data);
    }

    // FUNGSI UNTUK MEMPROSES SUBMIT FORM PESAN & REGISTRASI
    public function storePesan()
    {
        $db = \Config\Database::connect();

        // 1. Ambil data inputan form
        $id_kamar = $this->request->getPost('id_kamar');
        $harga_kamar = $this->request->getPost('harga_kamar');
        $nama = $this->request->getPost('nama');
        $email = $this->request->getPost('email'); // Menggunakan Email
        $password = $this->request->getPost('password');
        $no_hp = $this->request->getPost('no_hp');

        // Konversi Jenis Kelamin ke format DB (L / P)
        $jk_input = $this->request->getPost('jenis_kelamin');
        $jenis_kelamin = ($jk_input == 'Laki-laki') ? 'L' : 'P';

        $tanggal_masuk = $this->request->getPost('tanggal_masuk');
        $durasi_sewa = $this->request->getPost('durasi_sewa');

        // Validasi: Cek apakah Email sudah terdaftar di tabel users
        $cekUser = $db->table('users')->where('email', $email)->get()->getRowArray();
        if ($cekUser) {
            return redirect()->back()->with('error', 'Email sudah terdaftar. Silakan gunakan email lain atau login.');
        }

        // 2. Proses Upload Bukti Bayar
        $fileBukti = $this->request->getFile('bukti_bayar');
        $namaFileBukti = '';
        if ($fileBukti && $fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $namaFileBukti = $fileBukti->getRandomName();
            $fileBukti->move('uploads/bukti/', $namaFileBukti);
        }

        // --- MULAI TRANSAKSI DATABASE (Aman dari kegagalan parsial) ---
        $db->transStart();

        // 3. Insert ke Tabel `users`
        $db->table('users')->insert([
            'nama'     => $nama,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'no_hp'    => $no_hp,
            'role'     => 'penghuni',
            'status'   => 'nonaktif' // Menunggu admin konfirmasi
        ]);
        $id_user = $db->insertID();

        // 4. Insert ke Tabel `penghuni`
        $db->table('penghuni')->insert([
            'id_user'       => $id_user,
            'jenis_kelamin' => $jenis_kelamin
        ]);
        $id_penghuni = $db->insertID();

        // 5. Insert ke Tabel `sewa`
        $db->table('sewa')->insert([
            'id_kamar'    => $id_kamar,
            'id_penghuni' => $id_penghuni,
            'tgl_mulai'   => $tanggal_masuk,
            'durasi_bulan' => $durasi_sewa,
            'status'      => 'pending'
        ]);
        $id_sewa = $db->insertID();

        // 6. Insert ke Tabel `tagihan`
        $total_tagihan = $harga_kamar * $durasi_sewa;
        $periode = date('F Y', strtotime($tanggal_masuk)); // Format: Agustus 2026

        $db->table('tagihan')->insert([
            'id_sewa'         => $id_sewa,
            'periode_bulan'   => $periode,
            'jumlah'          => $total_tagihan,
            'tgl_jatuh_tempo' => $tanggal_masuk,
            'status'          => 'menunggu_konfirmasi'
        ]);
        $id_tagihan = $db->insertID();

        // 7. Insert ke Tabel `pembayaran`
        if ($namaFileBukti != '') {
            $db->table('pembayaran')->insert([
                'id_tagihan'     => $id_tagihan,
                'tgl_bayar'      => date('Y-m-d'),
                'bukti_transfer' => $namaFileBukti,
                'metode'         => 'transfer'
            ]);
        }

        // --- SELESAI TRANSAKSI ---
        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            // Jika ada satu proses gagal, kembalikan error
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Pengajuan gagal diproses.');
        }

        return redirect()->to('/')->with('pesan', 'Pengajuan sewa & pendaftaran akun berhasil dikirim! Silakan tunggu konfirmasi dari Admin.');
    }
}
