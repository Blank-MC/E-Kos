<?php

namespace App\Controllers\Penghuni;

use App\Controllers\BaseController;
use App\Models\SewaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Proteksi: Lempar ke login jika belum masuk atau bukan penghuni
        if (!session()->get('logged_in') || session()->get('role') != 'penghuni') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $sewaModel = new SewaModel();
        $id_user = session()->get('id_user');

        // Ambil data sewa terakhir milik user ini beserta detail kamar
        $sewa = $sewaModel->select('sewa.*, kamar.nama_kamar, kamar.foto')
            ->join('kamar', 'kamar.id = sewa.id_kamar')
            ->where('id_user', $id_user)
            ->orderBy('sewa.id', 'DESC')
            ->first();

        $data = [
            'title' => 'Dashboard Penghuni | E-Kos',
            'sewa'  => $sewa
        ];

        return view('penghuni/dashboard', $data);
    }
}
