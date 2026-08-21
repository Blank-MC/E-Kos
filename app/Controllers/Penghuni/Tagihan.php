<?php

namespace App\Controllers\Penghuni;

use App\Controllers\BaseController;

class Tagihan extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'penghuni') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');

        // 1. CEK APAKAH AKUN DINONAKTIFKAN KARENA SEWA SELESAI
        $userCek = $db->table('users')->where('id', $id_user)->get()->getRowArray();
        if (!$userCek || $userCek['status'] !== 'aktif') {
            session()->destroy();
            return redirect()->to('/')->with('error', 'Masa sewa Anda telah selesai dan akun telah dinonaktifkan.');
        }

        $todayStr = date('Y-m-d');

        // 2. AUTO-UPDATE: Ubah tagihan yang lewat jatuh tempo jadi 'terlambat'
        $db->table('tagihan')
            ->where('status', 'belum_bayar')
            ->where('tgl_jatuh_tempo <', $todayStr)
            ->update(['status' => 'terlambat']);

        $penghuni = $db->table('penghuni')->where('id_user', $id_user)->get()->getRowArray();
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();

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

        // 4. Ambil seluruh riwayat tagihan
        $tagihan = [];
        if ($penghuni) {
            $tagihan = $db->table('tagihan')
                ->select('tagihan.*, sewa.id_kamar, kamar.nama_kamar, pembayaran.bukti_transfer, pembayaran.tgl_bayar')
                ->join('sewa', 'sewa.id = tagihan.id_sewa')
                ->join('kamar', 'kamar.id = sewa.id_kamar')
                ->join('pembayaran', 'pembayaran.id_tagihan = tagihan.id', 'left')
                ->where('sewa.id_penghuni', $penghuni['id'])
                ->orderBy('tagihan.tgl_jatuh_tempo', 'DESC')
                ->get()->getResultArray();

            $today = new \DateTime($todayStr);
            foreach ($tagihan as &$t) {
                if ($t['status'] != 'lunas') {
                    $due = new \DateTime($t['tgl_jatuh_tempo']);
                    $diff = $today->diff($due);
                    $t['is_expired'] = ($today > $due);
                    $t['sisa_hari']  = $diff->days;
                } else {
                    $t['is_expired'] = false;
                    $t['sisa_hari']  = 0;
                }
            }
        }

        $data = [
            'title'      => 'Riwayat & Pembayaran Tagihan | ' . ($pengaturan['nama_kos'] ?? 'E-Kos'),
            'tagihan'    => $tagihan,
            'pengaturan' => $pengaturan
        ];

        return view('penghuni/tagihan', $data);
    }

    public function bayar()
    {
        if (!session()->get('logged_in') || session()->get('role') != 'penghuni') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');

        // Validasi Akun Aktif
        $userCek = $db->table('users')->where('id', $id_user)->get()->getRowArray();
        if (!$userCek || $userCek['status'] !== 'aktif') {
            session()->destroy();
            return redirect()->to('/')->with('error', 'Masa sewa Anda telah selesai dan akun telah dinonaktifkan.');
        }

        $id_tagihan = $this->request->getPost('id_tagihan');
        $fileBukti  = $this->request->getFile('bukti_bayar');

        if ($fileBukti && $fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $namaFile = $fileBukti->getRandomName();
            $fileBukti->move('uploads/bukti/', $namaFile);

            $db->transStart();

            $cekBayar = $db->table('pembayaran')->where('id_tagihan', $id_tagihan)->get()->getRowArray();

            if ($cekBayar) {
                $db->table('pembayaran')->where('id_tagihan', $id_tagihan)->update([
                    'tgl_bayar'      => date('Y-m-d'),
                    'metode'         => 'transfer',
                    'bukti_transfer' => $namaFile
                ]);
            } else {
                $db->table('pembayaran')->insert([
                    'id_tagihan'     => $id_tagihan,
                    'tgl_bayar'      => date('Y-m-d'),
                    'metode'         => 'transfer',
                    'bukti_transfer' => $namaFile
                ]);
            }

            $db->table('tagihan')->where('id', $id_tagihan)->update([
                'status' => 'menunggu_konfirmasi'
            ]);

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->back()->with('error', 'Gagal memproses bukti pembayaran.');
            }

            return redirect()->back()->with('pesan', 'Bukti transfer berhasil dikirim! Menunggu konfirmasi admin.');
        }

        return redirect()->back()->with('error', 'File bukti pembayaran tidak valid atau format tidak didukung.');
    }
}
