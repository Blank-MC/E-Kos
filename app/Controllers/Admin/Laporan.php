<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TagihanModel;

class Laporan extends BaseController
{
    public function index()
    {
        $tagihanModel = new TagihanModel();
        $data = [
            'title'     => 'Laporan Pendapatan | E-Kos',
            'pendapatan' => $tagihanModel->where('status', 'lunas')->findAll()
        ];
        return view('admin/laporan/index', $data);
    }
}
