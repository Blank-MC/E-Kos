<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SewaModel;
use App\Models\KamarModel;

class Sewa extends BaseController
{
    protected $sewaModel;
    protected $kamarModel;

    public function __construct()
    {
        $this->sewaModel = new SewaModel();
        $this->kamarModel = new KamarModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengajuan Sewa | E-Kos',
            'sewa'  => $this->sewaModel->getSewaLengkap()
        ];
        return view('admin/sewa/index', $data);
    }

    public function updateStatus($id, $status)
    {
        // Ambil data sewa
        $sewa = $this->sewaModel->find($id);

        if ($status == 'aktif') {
            // Update status kamar jadi terisi
            $this->kamarModel->update($sewa['id_kamar'], ['status' => 'terisi']);
        }

        $this->sewaModel->update($id, ['status' => $status]);
        return redirect()->to('/admin/sewa')->with('pesan', 'Status pengajuan sewa berhasil diperbarui.');
    }
}
