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

        $penghuni = $db->table('penghuni')->where('id_user', $id_user)->get()->getRowArray();
        $pengaturan = $db->table('pengaturan')->get()->getRowArray();
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

            $today = new \DateTime(date('Y-m-d'));
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
        $id_tagihan = $this->request->getPost('id_tagihan');
        $fileBukti  = $this->request->getFile('bukti_bayar');

        if ($fileBukti && $fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $namaFile = $fileBukti->getRandomName();
            $fileBukti->move('uploads/bukti/', $namaFile);

            $db->transStart();

            // Cek apakah data pembayaran untuk tagihan ini sudah pernah dibuat sebelumnya
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

            // Ubah status tagihan menjadi menunggu konfirmasi
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
