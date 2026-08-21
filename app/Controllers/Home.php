<?php

namespace App\Controllers;

use App\Models\KamarModel;

class Home extends BaseController
{
    public function index()
    {
        $kamarModel = new KamarModel();
        $db = \Config\Database::connect();

        // Ambil data pengaturan kos
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();

        $data = [
            'title'      => ($pengaturan['nama_kos'] ?? 'E-Kos') . ' | Hunian Nyaman Seperti Di Rumah',
            'kamar'      => $kamarModel->findAll(),
            'pengaturan' => $pengaturan
        ];

        return view('guest/home', $data);
    }

    // FUNGSI UNTUK DETAIL KAMAR
    public function detail($id)
    {
        $kamarModel = new KamarModel();
        $db = \Config\Database::connect();

        $kamar = $kamarModel->find($id);
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();

        if (!$kamar) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kamar tidak ditemukan');
        }

        // Ambil Fasilitas Kamar Berdasarkan Relasi Many-to-Many
        $fasilitas = $db->table('kamar_fasilitas')
            ->join('fasilitas', 'fasilitas.id = kamar_fasilitas.id_fasilitas')
            ->where('kamar_fasilitas.id_kamar', $id)
            ->get()->getResultArray();

        // Ambil Galeri Multi-Foto Tambahan dari tabel `kamar_foto`
        $galeriFoto = $db->table('kamar_foto')
            ->where('id_kamar', $id)
            ->get()->getResultArray();

        $data = [
            'title'       => 'Detail Kamar | ' . $kamar['nama_kamar'],
            'kamar'       => $kamar,
            'fasilitas'   => $fasilitas,
            'galeriFoto'  => $galeriFoto,
            'pengaturan'  => $pengaturan
        ];

        return view('guest/detail', $data);
    }

    // FUNGSI UNTUK MENAMPILKAN FORM PESAN & REGISTRASI
    public function pesan($id)
    {
        $kamarModel = new \App\Models\KamarModel();
        $db = \Config\Database::connect();

        $kamar = $kamarModel->find($id);
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();

        // Validasi: Status di database adalah 'kosong'
        if (!$kamar || $kamar['status'] != 'kosong') {
            return redirect()->to('/')->with('error', 'Maaf, kamar tersebut tidak tersedia atau sudah penuh.');
        }

        $data = [
            'title'      => 'Form Pemesanan & Registrasi | ' . ($pengaturan['nama_kos'] ?? 'E-Kos'),
            'kamar'      => $kamar,
            'pengaturan' => $pengaturan
        ];

        return view('guest/pesan', $data);
    }

    // FUNGSI UNTUK MEMPROSES SUBMIT FORM PESAN & REGISTRASI
    public function storePesan()
    {
        $db = \Config\Database::connect();

        $id_kamar      = $this->request->getPost('id_kamar');
        $harga_kamar   = $this->request->getPost('harga_kamar');
        $nama          = $this->request->getPost('nama');
        $email         = $this->request->getPost('email');
        $password      = $this->request->getPost('password');
        $no_hp         = $this->request->getPost('no_hp');
        $jk_input      = $this->request->getPost('jenis_kelamin');
        $jenis_kelamin = ($jk_input == 'Laki-laki') ? 'L' : 'P';
        $tanggal_masuk = $this->request->getPost('tanggal_masuk');
        $durasi_sewa   = (int)$this->request->getPost('durasi_sewa');

        // Validasi ketersediaan kamar
        $cekKamar = $db->table('kamar')->where('id', $id_kamar)->get()->getRowArray();
        if (!$cekKamar || $cekKamar['status'] != 'kosong') {
            return redirect()->to('/')->with('error', 'Maaf, kamar ini baru saja dipesan oleh orang lain.');
        }

        // Cek email ganda
        $cekUser = $db->table('users')->where('email', $email)->get()->getRowArray();
        if ($cekUser) {
            return redirect()->back()->with('error', 'Email sudah terdaftar. Silakan gunakan email lain atau login.');
        }

        // Upload Bukti Bayar
        $fileBukti = $this->request->getFile('bukti_bayar');
        $namaFileBukti = '';
        if ($fileBukti && $fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $namaFileBukti = $fileBukti->getRandomName();
            $fileBukti->move('uploads/bukti/', $namaFileBukti);
        }

        // Hitung Tanggal Selesai dan Jatuh Tempo (ditambah durasi bulan)
        $tgl_selesai = date('Y-m-d', strtotime("+$durasi_sewa month", strtotime($tanggal_masuk)));
        $tgl_jatuh_tempo = $tgl_selesai;

        $db->transStart();

        // 1. Kunci Status Kamar
        $db->table('kamar')->where('id', $id_kamar)->update([
            'status' => 'terisi'
        ]);

        // 2. Insert ke Tabel `users`
        $db->table('users')->insert([
            'nama'     => $nama,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'no_hp'    => $no_hp,
            'role'     => 'penghuni',
            'status'   => 'nonaktif'
        ]);
        $id_user = $db->insertID();

        // 3. Insert ke Tabel `penghuni`
        $db->table('penghuni')->insert([
            'id_user'       => $id_user,
            'jenis_kelamin' => $jenis_kelamin
        ]);
        $id_penghuni = $db->insertID();

        // 4. Insert ke Tabel `sewa`
        $db->table('sewa')->insert([
            'id_kamar'     => $id_kamar,
            'id_penghuni'  => $id_penghuni,
            'tgl_mulai'    => $tanggal_masuk,
            'durasi_bulan' => $durasi_sewa,
            'tgl_selesai'  => $tgl_selesai,
            'status'       => 'pending'
        ]);
        $id_sewa = $db->insertID();

        // 5. Insert ke Tabel `tagihan`
        $total_tagihan = $harga_kamar * $durasi_sewa;
        $periode = date('F Y', strtotime($tanggal_masuk));

        $db->table('tagihan')->insert([
            'id_sewa'         => $id_sewa,
            'periode_bulan'   => $periode,
            'jumlah'          => $total_tagihan,
            'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
            'status'          => 'menunggu_konfirmasi'
        ]);
        $id_tagihan = $db->insertID();

        // 6. Insert ke Tabel `pembayaran`
        if ($namaFileBukti != '') {
            $db->table('pembayaran')->insert([
                'id_tagihan'     => $id_tagihan,
                'tgl_bayar'      => date('Y-m-d'),
                'bukti_transfer' => $namaFileBukti,
                'metode'         => 'transfer'
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Pengajuan gagal diproses.');
        }

        return redirect()->to('/')->with('pesan', 'Pengajuan sewa & pendaftaran akun berhasil dikirim!');
    }
}
