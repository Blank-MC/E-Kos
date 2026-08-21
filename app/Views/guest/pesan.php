<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>

    <!-- BOOTSTRAP 5 LOKAL -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap">

    <style>
        :root {
            --primary: #0d9488;
            --primary-hover: #0f766e;
            --dark: #1e293b;
            --light-bg: #f8fafc;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark);
        }

        .navbar-kos {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .form-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(13, 148, 136, 0.05);
            position: sticky;
            top: 100px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.25);
        }

        .btn-custom {
            background-color: var(--primary);
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 14px;
            border: none;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>

<body>

    <!-- Navbar Simple untuk Checkout -->
    <nav class="navbar navbar-light navbar-kos fixed-top py-3">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2 text-dark m-0" href="<?= base_url() ?>">
                <i class="fas fa-door-open text-primary fs-3"></i> <?= esc($pengaturan['nama_kos'] ?? 'E-KOS') ?> Checkout
            </a>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px; margin-bottom: 100px;">
        <a href="<?= base_url('kamar/detail/' . $kamar['id']) ?>" class="text-decoration-none text-muted mb-4 d-inline-block fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Detail Kamar
        </a>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('pesan/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="id_kamar" value="<?= $kamar['id']; ?>">
            <input type="hidden" name="harga_kamar" value="<?= $kamar['harga_bulanan']; ?>">

            <div class="row g-4">
                <!-- Kolom Kiri: Form -->
                <div class="col-lg-8">

                    <!-- Form Bagian 1: Akun & Data Diri -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-user-circle fs-4"></i> Data Diri & Pembuatan Akun
                        </div>
                        <p class="text-muted small mb-4">Isi data diri Anda. Email dan password ini akan digunakan untuk login ke aplikasi kos nantinya.</p>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="fw-bold mb-2">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" placeholder="Contoh: Budi Santoso" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold mb-2">Email Aktif</label>
                                <input type="email" class="form-control" name="email" placeholder="Contoh: budi@gmail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold mb-2">Password Baru</label>
                                <input type="password" class="form-control" name="password" placeholder="Minimal 6 karakter" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold mb-2">No. WhatsApp</label>
                                <input type="number" class="form-control" name="no_hp" placeholder="Contoh: 08123456789" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold mb-2">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin" required>
                                    <option value="">Pilih...</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Bagian 2: Data Sewa & Upload -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-calendar-check fs-4"></i> Rencana Sewa & Pembayaran
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="fw-bold mb-2">Rencana Tanggal Masuk</label>
                                <input type="date" class="form-control" name="tanggal_masuk" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold mb-2">Durasi Sewa Awal</label>
                                <select class="form-select" name="durasi_sewa" required>
                                    <option value="1">1 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">1 Tahun</option>
                                </select>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="alert alert-info rounded-3 border-0">
                                    <h6 class="fw-bold mb-2"><i class="fas fa-wallet me-2"></i>Instruksi Pembayaran</h6>
                                    <p class="small mb-0">Silakan transfer biaya sewa ke rekening pemilik kos:<br>
                                        <strong>BCA: 1234567890 a.n Pemilik Kos</strong><br>
                                        Setelah transfer, wajib upload bukti resi di bawah ini.
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="fw-bold mb-2">Upload Bukti Transfer (DP / Lunas)</label>
                                <input type="file" class="form-control" name="bukti_bayar" accept="image/png, image/jpeg, image/jpg" required>
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Kolom Kanan: Ringkasan & Submit -->
                <div class="col-lg-4">
                    <div class="summary-card">
                        <h5 class="fw-bold border-bottom pb-3 mb-4">Ringkasan Pesanan</h5>

                        <div class="d-flex gap-3 mb-3">
                            <img src="<?= base_url('uploads/kamar/' . ($kamar['foto_utama'] ?? 'default.jpg')) ?>" class="rounded-3" width="80" height="80" style="object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1598928506311-c55ded91a20c?q=80&w=200&auto=format&fit=crop'">
                            <div>
                                <h6 class="fw-bold mb-1"><?= esc($kamar['nama_kamar']) ?></h6>
                                <p class="text-muted small mb-0"><i class="fas fa-map-marker-alt me-1"></i> <?= esc($pengaturan['nama_kos'] ?? 'E-Kos') ?></p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-2 small text-muted">
                            <span>Harga per bulan</span>
                            <span class="fw-bold text-dark">Rp <?= number_format($kamar['harga_bulanan'], 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 small text-muted">
                            <span>Status Kamar</span>
                            <span class="fw-bold text-success">Tersedia</span>
                        </div>

                        <hr class="opacity-25 my-3">

                        <button type="submit" class="btn btn-custom w-100 d-block text-center mt-2 shadow-sm">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Sewa
                        </button>
                        <p class="text-center text-muted small mt-3 mb-0">
                            Dengan menekan tombol di atas, Anda setuju dengan peraturan kos dan membuat akun secara otomatis.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- JS BOOTSTRAP LOKAL -->
    <script src="<?= base_url('assets/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>