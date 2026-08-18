<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // Angka dummy sementara sebelum kita integrasikan dengan database penuh
        $data = [
            'title'                => 'Dashboard Admin | E-Kos',
            'total_kamar'          => 10,
            'kamar_terisi'         => 8,
            'kamar_kosong'         => 2,
            'pendapatan_bulan_ini' => 9600000
        ];

        // Mengarahkan ke folder khusus dashboard
        return view('admin/dashboard/index', $data);
    }
}
