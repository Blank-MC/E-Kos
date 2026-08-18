<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KamarModel;
use App\Models\TagihanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $kamarModel  = new KamarModel();
        $tagihanModel = new TagihanModel();

        // 1. Hitung total kamar secara real-time dari database
        $totalKamar  = $kamarModel->countAll();

        // 2. Hitung jumlah kamar berdasarkan statusnya
        $kamarTerisi = $kamarModel->where('status', 'terisi')->countAllResults();
        $kamarKosong = $kamarModel->where('status', 'kosong')->countAllResults();

        // 3. Hitung total pendapatan bulan ini (dari tagihan dengan status 'lunas' pada bulan berjalan)
        // Format periode_bulan di database misal: 'Agustus 2026' atau sesuaikan format bulanan lu
        $bulanAktif  = date('F Y'); // Contoh: August 2026 atau sesuaikan string periode

        // Mengambil jumlah sum dari tagihan lunas bulan ini
        $db = \Config\Database::connect();
        $pendapatan = $db->table('tagihan')
            ->selectSum('jumlah')
            ->where('status', 'lunas')
            ->get()->getRow()->jumlah ?? 0;

        $data = [
            'title'                => 'Dashboard Admin | E-Kos',
            'total_kamar'          => $totalKamar,
            'kamar_terisi'         => $kamarTerisi,
            'kamar_kosong'         => $kamarKosong,
            'pendapatan_bulan_ini' => $pendapatan
        ];

        return view('admin/dashboard/index', $data);
    }
}
