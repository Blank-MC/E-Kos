# 🏢 E-Kos Indonesia - Sistem Manajemen Kos Modern

[![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter%204-EF4444?style=flat-square&logo=codeigniter&logoColor=white)](https://codeigniter.com/)
[![Bootstrap](https://img.shields.io/badge/UI-Bootstrap%205-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE)

**E-Kos Indonesia** adalah aplikasi berbasis web yang dirancang untuk mengotomatisasi seluruh siklus manajemen kos-kosan. Sistem ini mengintegrasikan portal landing page publik untuk calon penyewa, panel kontrol terpusat untuk Administrator, dan portal mandiri (_self-service_) bagi Penghuni kos.

---

## 🌟 Fitur Utama

### 🌐 1. Publik / Calon Penghuni (Guest)

- **Katalog Kamar Interaktif:** Menampilkan detail kamar, spesifikasi ukuran, daftar fasilitas, serta galeri foto kamar.
- **Filter & Pencarian:** Navigasi cepat berdasarkan tipe dan ketersediaan kamar.
- **Pemesanan Mandiri (Self Booking):** Alur registrasi pemesanan instan yang otomatis mengunci status kamar dan membuat akun penghuni.

### 👤 2. Panel Penghuni

- **Dashboard Ringkas:** Menampilkan data kamar yang disewa, durasi sewa, dan ringkasan tagihan berjalan.
- **Manajemen & Pembayaran Tagihan:**
  - Penghitungan otomatis masa tenggat jatuh tempo (_countdown_ sisa hari).
  - Upload bukti transfer pembayaran dengan status verifikasi _real-time_.
  - Tagihan bulan berikutnya terbit secara otomatis (_Auto-Generate_).
- **Pusat Pengaduan:** Layanan pengajuan keluhan/kerusakan fasilitas kos langsung ke pihak pengelola kos.
- **Profil & Keamanan:** Pembaruan data diri, upload berkas KTP, dan penggantian kata sandi berenkripsi.

### 🛠️ 3. Panel Admin (Pengelola Kos)

- **Analitik Dashboard:** Statistik visual grafik pendapatan bulanan (_Chart.js_) dan ringkasan status kamar.
- **Manajemen Kamar & Galeri:** CRUD kamar, pengaturan fasilitas, dan multi-upload foto galeri.
- **Verifikasi Transaksi:** Konfirmasi pembayaran masuk dari penghuni dalam satu klik.
- **Respon Pengaduan:** Penanganan dan pembaruan status keluhan penghuni (Baru, Diproses, Selesai).
- **Manajemen Akun & Penghuni:** Reset password akun penghuni dan kontrol akses sewa.
- **Ekspor Laporan:** Rekap data transaksi dan pendapatan kos ke format **PDF** dan **Excel (.xlsx)**.
- **Pengaturan Kos:** Konfigurasi informasi kos, nomor kontak, rekening pembayaran, dan lokasi.

---

## ⚙️ Otomatisasi Sistem (_Business Logic Automation_)

- **Auto-Update Keterlambatan:** Status tagihan otomatis beralih menjadi `terlambat` jika telah melewati tanggal jatuh tempo.
- **Auto-Generate Tagihan Baru:** Tagihan periode berikutnya otomatis terbit jika masa sewa aktif berlanjut ke bulan berikutnya.
- **Auto-Selesai Sewa & Deaktivasi Akun:** Saat admin mengubah status kamar menjadi `kosong`, status sewa otomatis diselesaikan (`selesai`) dan akun penghuni otomatis dinonaktifkan (`nonaktif`) sehingga sesi login ditutup.

---

## 💻 Tech Stack

- **Backend:** PHP 8.1+ & CodeIgniter 4
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript (ES6+), Bootstrap 5
- **Libraries & Plugins:**
  - Chart.js (Grafik & Analitik)
  - FontAwesome 6 (Ikon antarmuka)
  - DataTables (Tabel interaktif)
  - Dompdf / PhpSpreadsheet (Ekspor Laporan)

---

## 🚀 Panduan Instalasi Lokal

### 1. Prasyarat Sistem

- Web Server (Apache / Nginx / XAMPP / Laragon)
- PHP versi **8.1** atau lebih baru (ekstensi `intl`, `mbstring`, `curl`, `gd` aktif)
- Composer (opsional untuk manajemen dependensi)
- MySQL Database

### 2. Kloning / Unduh Repositori

```bash
git clone [https://github.com/username/e-kos.git](https://github.com/username/e-kos.git)
cd e-kos
```
