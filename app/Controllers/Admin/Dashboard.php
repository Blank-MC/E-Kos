<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KamarModel;
use App\Models\TagihanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu sebagai Admin.');
        }

        $kamarModel  = new KamarModel();
        $db          = \Config\Database::connect();

        // 1. Hitung total kamar & statusnya
        $totalKamar  = $kamarModel->countAll();
        $kamarTerisi = $kamarModel->where('status', 'terisi')->countAllResults();
        $kamarKosong = $kamarModel->where('status', 'kosong')->countAllResults();

        // 2. Hitung total pendapatan lunas
        $pendapatan = $db->table('tagihan')
            ->selectSum('jumlah')
            ->where('status', 'lunas')
            ->get()->getRow()->jumlah ?? 0;

        // 3. Agregasi Pendapatan per Bulan untuk Grafik Tahun Ini
        $tahunIni = date('Y');
        $pendapatanPerBulan = array_fill(1, 12, 0);

        $tagihanLunas = $db->table('tagihan')
            ->select('MONTH(tgl_jatuh_tempo) as bulan, SUM(jumlah) as total')
            ->where('status', 'lunas')
            ->where('YEAR(tgl_jatuh_tempo)', $tahunIni)
            ->groupBy('MONTH(tgl_jatuh_tempo)')
            ->get()->getResultArray();

        foreach ($tagihanLunas as $row) {
            $pendapatanPerBulan[(int)$row['bulan']] = (float)$row['total'];
        }

        $data = [
            'title'                => 'Dashboard Admin | E-Kos',
            'total_kamar'          => $totalKamar,
            'kamar_terisi'         => $kamarTerisi,
            'kamar_kosong'         => $kamarKosong,
            'pendapatan_bulan_ini' => $pendapatan,
            'grafik_pendapatan'    => array_values($pendapatanPerBulan),
            'tahun_ini'            => $tahunIni
        ];

        return view('admin/dashboard/index', $data);
    }
}
