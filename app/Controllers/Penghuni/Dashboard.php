<?php

namespace App\Controllers\Penghuni;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'penghuni') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');

        $pengaturan = $db->table('pengaturan')->get()->getRowArray();
        $penghuni = $db->table('penghuni')->where('id_user', $id_user)->get()->getRowArray();

        $sewa = null;
        $tagihan = null;
        $tenggat_info = null;

        if ($penghuni) {
            $sewa = $db->table('sewa')
                ->select('sewa.*, kamar.nama_kamar, kamar.foto_utama, kamar.harga_bulanan')
                ->join('kamar', 'kamar.id = sewa.id_kamar')
                ->where('sewa.id_penghuni', $penghuni['id'])
                ->orderBy('sewa.id', 'DESC')
                ->get()->getRowArray();

            if ($sewa) {
                $tagihan = $db->table('tagihan')
                    ->where('id_sewa', $sewa['id'])
                    ->orderBy('id', 'DESC')
                    ->get()->getRowArray();

                if ($tagihan && $tagihan['status'] != 'lunas') {
                    $today = new \DateTime(date('Y-m-d'));
                    $dueDate = new \DateTime($tagihan['tgl_jatuh_tempo']);
                    $diff = $today->diff($dueDate);

                    if ($today > $dueDate) {
                        $tenggat_info = [
                            'status' => 'terlambat',
                            'teks'   => 'Terlambat ' . $diff->days . ' hari (Jatuh tempo: ' . date('d M Y', strtotime($tagihan['tgl_jatuh_tempo'])) . ')'
                        ];
                    } else {
                        $tenggat_info = [
                            'status' => 'mendekati',
                            'teks'   => $diff->days . ' hari lagi (Batas: ' . date('d M Y', strtotime($tagihan['tgl_jatuh_tempo'])) . ')'
                        ];
                    }
                }
            }
        }

        $data = [
            'title'        => 'Dashboard Penghuni | ' . ($pengaturan['nama_kos'] ?? 'E-Kos'),
            'sewa'         => $sewa,
            'tagihan'      => $tagihan,
            'tenggat_info' => $tenggat_info,
            'pengaturan'   => $pengaturan
        ];

        return view('penghuni/dashboard', $data);
    }
}
