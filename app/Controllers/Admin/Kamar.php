<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KamarModel;
use App\Models\FasilitasModel;
use App\Models\KamarFotoModel;

class Kamar extends BaseController
{
    protected $kamarModel;
    protected $fasilitasModel;
    protected $kamarFotoModel;
    protected $db;

    public function __construct()
    {
        $this->kamarModel     = new KamarModel();
        $this->fasilitasModel = new FasilitasModel();
        $this->kamarFotoModel = new KamarFotoModel();
        $this->db             = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Kamar | E-Kos',
            'kamar' => $this->kamarModel->findAll()
        ];
        return view('admin/kamar/index', $data);
    }

    public function create()
    {
        $data = [
            'title'     => 'Tambah Kamar | E-Kos',
            'fasilitas' => $this->fasilitasModel->findAll()
        ];
        return view('admin/kamar/create', $data);
    }

    public function store()
    {
        // 1. Upload Foto Utama
        $fileFoto = $this->request->getFile('foto_utama');
        $namaFoto = '';

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/kamar', $namaFoto);
        }

        // 2. Simpan Data Utama Kamar
        $this->kamarModel->save([
            'nama_kamar'    => $this->request->getPost('nama_kamar'),
            'tipe'          => $this->request->getPost('tipe'),
            'harga_bulanan' => $this->request->getPost('harga_bulanan'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'ukuran'        => $this->request->getPost('ukuran'),
            'status'        => $this->request->getPost('status'),
            'foto_utama'    => $namaFoto
        ]);

        $idKamarBaru = $this->kamarModel->getInsertID();

        // 3. Simpan Relasi Checkbox Fasilitas
        $fasilitasPilihan = $this->request->getPost('fasilitas');
        if (!empty($fasilitasPilihan)) {
            foreach ($fasilitasPilihan as $idFasilitas) {
                $this->db->table('kamar_fasilitas')->insert([
                    'id_kamar'     => $idKamarBaru,
                    'id_fasilitas' => $idFasilitas
                ]);
            }
        }

        // 4. Simpan Multi-Upload Galeri Foto Kamar
        $galeriFoto = $this->request->getFileMultiple('galeri_foto');
        if ($galeriFoto) {
            foreach ($galeriFoto as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $namaGaleri = $img->getRandomName();
                    $img->move('uploads/kamar/galeri', $namaGaleri);

                    $this->kamarFotoModel->save([
                        'id_kamar'  => $idKamarBaru,
                        'file_foto' => $namaGaleri
                    ]);
                }
            }
        }

        return redirect()->to('/admin/kamar')->with('pesan', 'Data kamar, fasilitas, dan galeri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil relasi fasilitas yang aktif
        $fasilitasTerpilih = $this->db->table('kamar_fasilitas')->where('id_kamar', $id)->get()->getResultArray();
        $idFasilitasAktif  = array_column($fasilitasTerpilih, 'id_fasilitas');

        // Ambil data galeri foto
        $galeriList = $this->kamarFotoModel->where('id_kamar', $id)->findAll();

        $data = [
            'title'            => 'Edit Kamar | E-Kos',
            'kamar'            => $this->kamarModel->find($id),
            'fasilitas'        => $this->fasilitasModel->findAll(),
            'idFasilitasAktif' => $idFasilitasAktif,
            'galeriList'       => $galeriList
        ];
        return view('admin/kamar/edit', $data);
    }

    public function update($id)
    {
        $kamarLama    = $this->kamarModel->find($id);
        $status_kamar = $this->request->getPost('status');

        // Handle Foto Utama
        $fileFoto = $this->request->getFile('foto_utama');
        $namaFoto = $kamarLama['foto_utama'];

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/kamar', $namaFoto);
            if ($kamarLama['foto_utama'] != '' && file_exists('uploads/kamar/' . $kamarLama['foto_utama'])) {
                unlink('uploads/kamar/' . $kamarLama['foto_utama']);
            }
        }

        $this->db->transStart();

        // 1. Update Data Utama Kamar
        $this->kamarModel->save([
            'id'            => $id,
            'nama_kamar'    => $this->request->getPost('nama_kamar'),
            'tipe'          => $this->request->getPost('tipe'),
            'harga_bulanan' => $this->request->getPost('harga_bulanan'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'ukuran'        => $this->request->getPost('ukuran'),
            'status'        => $status_kamar,
            'foto_utama'    => $namaFoto
        ]);

        // 2. OTOMATISASI: Jika status diubah jadi 'kosong', selesaikan sewa & nonaktifkan akun user
        if ($status_kamar === 'kosong') {
            $sewaAktif = $this->db->table('sewa')
                ->select('sewa.id, penghuni.id_user')
                ->join('penghuni', 'penghuni.id = sewa.id_penghuni')
                ->where('sewa.id_kamar', $id)
                ->where('sewa.status', 'aktif')
                ->get()->getResultArray();

            if (!empty($sewaAktif)) {
                $idUsersNonaktif = [];
                $idSewaSelesai   = [];

                foreach ($sewaAktif as $row) {
                    $idSewaSelesai[]   = $row['id'];
                    $idUsersNonaktif[] = $row['id_user'];
                }

                // Selesaikan masa sewa
                $this->db->table('sewa')
                    ->whereIn('id', $idSewaSelesai)
                    ->update([
                        'status'      => 'selesai',
                        'tgl_selesai' => date('Y-m-d')
                    ]);

                // Nonaktifkan akun login user penghuni
                $this->db->table('users')
                    ->whereIn('id', $idUsersNonaktif)
                    ->update([
                        'status' => 'nonaktif'
                    ]);
            }
        }

        // 3. Update Fasilitas (Hapus lalu insert ulang)
        $this->db->table('kamar_fasilitas')->where('id_kamar', $id)->delete();
        $fasilitasPilihan = $this->request->getPost('fasilitas');
        if (!empty($fasilitasPilihan)) {
            foreach ($fasilitasPilihan as $idFasilitas) {
                $this->db->table('kamar_fasilitas')->insert([
                    'id_kamar'     => $id,
                    'id_fasilitas' => $idFasilitas
                ]);
            }
        }

        // 4. Tambahan Multi-Upload Galeri Foto Baru saat Edit
        $galeriFoto = $this->request->getFileMultiple('galeri_foto');
        if ($galeriFoto) {
            foreach ($galeriFoto as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $namaGaleri = $img->getRandomName();
                    $img->move('uploads/kamar/galeri', $namaGaleri);

                    $this->kamarFotoModel->save([
                        'id_kamar'  => $id,
                        'file_foto' => $namaGaleri
                    ]);
                }
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal memperbarui data kamar.');
        }

        return redirect()->to('/admin/kamar')->with('pesan', 'Data kamar berhasil diupdate.');
    }

    // Hapus Foto Galeri Satuan
    public function deleteFoto($id_foto, $id_kamar)
    {
        $foto = $this->kamarFotoModel->find($id_foto);
        if ($foto) {
            if (file_exists('uploads/kamar/galeri/' . $foto['file_foto'])) {
                unlink('uploads/kamar/galeri/' . $foto['file_foto']);
            }
            $this->kamarFotoModel->delete($id_foto);
        }
        return redirect()->to('/admin/kamar/edit/' . $id_kamar)->with('pesan', 'Foto galeri berhasil dihapus.');
    }

    public function delete($id)
    {
        $kamar = $this->kamarModel->find($id);
        if ($kamar['foto_utama'] != '' && file_exists('uploads/kamar/' . $kamar['foto_utama'])) {
            unlink('uploads/kamar/' . $kamar['foto_utama']);
        }

        // Hapus file fisik galeri terkait
        $galeri = $this->kamarFotoModel->where('id_kamar', $id)->findAll();
        foreach ($galeri as $g) {
            if (file_exists('uploads/kamar/galeri/' . $g['file_foto'])) {
                unlink('uploads/kamar/galeri/' . $g['file_foto']);
            }
        }

        $this->kamarModel->delete($id);
        return redirect()->to('/admin/kamar')->with('pesan', 'Kamar berhasil dihapus.');
    }
}
