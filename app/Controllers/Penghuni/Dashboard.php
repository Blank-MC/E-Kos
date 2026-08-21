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
        $todayStr = date('Y-m-d');

        // 1. AUTO-UPDATE: Ubah tagihan yang lewat jatuh tempo jadi 'terlambat'
        $db->table('tagihan')
            ->where('status', 'belum_bayar')
            ->where('tgl_jatuh_tempo <', $todayStr)
            ->update(['status' => 'terlambat']);

        // 2. Ambil Data Profil & Pengaturan
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();
        $penghuni = $db->table('penghuni')->where('id_user', $id_user)->get()->getRowArray();

        // 3. AUTO-GENERATE TAGIHAN BULAN BERIKUTNYA UNTUK SEWA AKTIF
        if ($penghuni) {
            $sewaAktifList = $db->table('sewa')
                ->select('sewa.*, kamar.harga_bulanan')
                ->join('kamar', 'kamar.id = sewa.id_kamar')
                ->where('sewa.id_penghuni', $penghuni['id'])
                ->where('sewa.status', 'aktif')
                ->get()->getResultArray();

            foreach ($sewaAktifList as $sw) {
                $lastTagihan = $db->table('tagihan')
                    ->where('id_sewa', $sw['id'])
                    ->orderBy('tgl_jatuh_tempo', 'DESC')
                    ->get()->getRowArray();

                if ($lastTagihan) {
                    // Jika hari ini sudah mencapai/melewati jatuh tempo tagihan sebelumnya
                    if ($todayStr >= $lastTagihan['tgl_jatuh_tempo']) {
                        $nextDue = date('Y-m-d', strtotime('+1 month', strtotime($lastTagihan['tgl_jatuh_tempo'])));
                        $nextPeriode = date('F Y', strtotime($nextDue));

                        $cekAda = $db->table('tagihan')
                            ->where('id_sewa', $sw['id'])
                            ->where('periode_bulan', $nextPeriode)
                            ->countAllResults();

                        if ($cekAda == 0) {
                            $db->table('tagihan')->insert([
                                'id_sewa'         => $sw['id'],
                                'periode_bulan'   => $nextPeriode,
                                'jumlah'          => $sw['harga_bulanan'],
                                'tgl_jatuh_tempo' => $nextDue,
                                'status'          => 'belum_bayar'
                            ]);
                        }
                    }
                }
            }
        }

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
                // Ambil tagihan terbaru
                $tagihan = $db->table('tagihan')
                    ->where('id_sewa', $sewa['id'])
                    ->orderBy('id', 'DESC')
                    ->get()->getRowArray();

                if ($tagihan && $tagihan['status'] != 'lunas') {
                    $today = new \DateTime($todayStr);
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
