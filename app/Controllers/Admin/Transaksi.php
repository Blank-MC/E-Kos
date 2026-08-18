<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagihanModel;
use App\Models\PembayaranModel;

class Transaksi extends BaseController
{
    protected $tagihanModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->tagihanModel = new TagihanModel();
        $this->pembayaranModel = new PembayaranModel();
    }

    // Menampilkan daftar tagihan lengkap dengan status pembayarannya
    public function index()
    {
        // Gunakan query builder untuk mengambil tagihan beserta data pembayaran jika ada
        $db = \Config\Database::connect();
        $tagihan = $db->table('tagihan')
            ->select('tagihan.*, kamar.nama_kamar, users.nama as nama_penghuni, pembayaran.bukti_transfer, pembayaran.tgl_bayar, pembayaran.metode')
            ->join('sewa', 'sewa.id = tagihan.id_sewa')
            ->join('kamar', 'kamar.id = sewa.id_kamar')
            ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
            ->join('users', 'users.id = penghuni.id_user')
            ->join('pembayaran', 'pembayaran.id_tagihan = tagihan.id', 'left')
            ->get()->getResultArray();

        $data = [
            'title'   => 'Validasi Transaksi & Pembayaran | E-Kos',
            'tagihan' => $tagihan
        ];

        return view('admin/transaksi/index', $data);
    }

    // Aksi Admin Mengonfirmasi Pembayaran
    public function konfirmasi($id_tagihan)
    {
        // 1. Update status tagihan jadi lunas
        $this->tagihanModel->update($id_tagihan, ['status' => 'lunas']);

        // 2. Cek apakah data di tabel pembayaran sudah ada, jika belum masukkan record baru
        $cekBayar = $this->pembayaranModel->where('id_tagihan', $id_tagihan)->first();

        // Ambil ID admin yang sedang login (simulasi pakai ID 1 atau dari session auth)
        $idAdmin = session()->get('id') ?? 1;

        if (!$cekBayar) {
            $this->pembayaranModel->save([
                'id_tagihan'        => $id_tagihan,
                'tgl_bayar'         => date('Y-m-d'),
                'metode'            => 'Transfer Manual',
                'dikonfirmasi_oleh' => $idAdmin,
                'tgl_konfirmasi'    => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->pembayaranModel->update($cekBayar['id'], [
                'dikonfirmasi_oleh' => $idAdmin,
                'tgl_konfirmasi'    => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/admin/transaksi')->with('pesan', 'Pembayaran tagihan berhasil dikonfirmasi lunas.');
    }
}
