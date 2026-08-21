<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagihanModel;

class Laporan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil data tagihan lunas beserta detail kamar & nama penghuni
        $pendapatan = $db->table('tagihan')
            ->select('tagihan.*, kamar.nama_kamar, users.nama as nama_penghuni')
            ->join('sewa', 'sewa.id = tagihan.id_sewa')
            ->join('kamar', 'kamar.id = sewa.id_kamar')
            ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
            ->join('users', 'users.id = penghuni.id_user')
            ->where('tagihan.status', 'lunas')
            ->orderBy('tagihan.id', 'DESC')
            ->get()->getResultArray();

        $data = [
            'title'      => 'Laporan Pendapatan | E-Kos',
            'pendapatan' => $pendapatan
        ];
        return view('admin/laporan/index', $data);
    }

    public function exportExcel()
    {
        $db = \Config\Database::connect();

        $pendapatan = $db->table('tagihan')
            ->select('tagihan.*, kamar.nama_kamar, users.nama as nama_penghuni')
            ->join('sewa', 'sewa.id = tagihan.id_sewa')
            ->join('kamar', 'kamar.id = sewa.id_kamar')
            ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
            ->join('users', 'users.id = penghuni.id_user')
            ->where('tagihan.status', 'lunas')
            ->orderBy('tagihan.id', 'DESC')
            ->get()->getResultArray();

        $filename = 'Laporan_Pendapatan_Kos_' . date('Y-m-d_H-i') . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<table border="1">';
        echo '<thead>
                <tr style="background-color: #f2f2f2;">
                    <th>No</th>
                    <th>Periode</th>
                    <th>Nama Penghuni</th>
                    <th>Kamar</th>
                    <th>Jumlah (Rp)</th>
                    <th>Status</th>
                </tr>
              </thead>';
        echo '<tbody>';
        $no = 1;
        $total = 0;
        foreach ($pendapatan as $p) {
            $total += $p['jumlah'];
            echo '<tr>';
            echo '<td style="text-align: center;">' . $no++ . '</td>';
            echo '<td>' . $p['periode_bulan'] . '</td>';
            echo '<td>' . $p['nama_penghuni'] . '</td>';
            echo '<td>' . $p['nama_kamar'] . '</td>';
            echo '<td>' . number_format($p['jumlah'], 0, ',', '.') . '</td>';
            echo '<td style="text-align: center;">LUNAS</td>';
            echo '</tr>';
        }
        echo '<tr>
                <th colspan="4" style="text-align: right;">Total Pendapatan:</th>
                <th colspan="2" style="text-align: left;">Rp ' . number_format($total, 0, ',', '.') . '</th>
              </tr>';
        echo '</tbody>';
        echo '</table>';
        exit;
    }

    public function exportPdf()
    {
        $db = \Config\Database::connect();

        $pendapatan = $db->table('tagihan')
            ->select('tagihan.*, kamar.nama_kamar, users.nama as nama_penghuni')
            ->join('sewa', 'sewa.id = tagihan.id_sewa')
            ->join('kamar', 'kamar.id = sewa.id_kamar')
            ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
            ->join('users', 'users.id = penghuni.id_user')
            ->where('tagihan.status', 'lunas')
            ->orderBy('tagihan.id', 'DESC')
            ->get()->getResultArray();

        $pengaturan = $db->table('pengaturan')->get()->getRowArray();

        $data = [
            'title'      => 'Cetak Laporan Pendapatan',
            'pendapatan' => $pendapatan,
            'pengaturan' => $pengaturan
        ];

        return view('admin/laporan/cetak_pdf', $data);
    }
}
