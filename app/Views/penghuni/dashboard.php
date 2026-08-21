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
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .navbar-kos {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card-panel {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Navbar Penghuni -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-kos py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-teal" href="#"><i class="fas fa-door-open text-primary"></i> E-KOS</a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="fw-bold d-none d-md-block"><i class="fas fa-user-circle me-1"></i> Halo, <?= session()->get('nama') ?></span>
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm fw-bold rounded-pill px-3"><i class="fas fa-sign-out-alt me-1"></i> Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="fw-bold mb-4">Dashboard Kos Anda</h3>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success rounded-3"><i class="fas fa-check-circle me-1"></i> <?= session()->getFlashdata('pesan') ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Status Kamar -->
                <div class="card card-panel">
                    <div class="card-body p-4">
                        <h5 class="fw-bold border-bottom pb-3 mb-4"><i class="fas fa-bed text-primary me-2"></i> Info Kamar Saat Ini</h5>

                        <?php if ($sewa) : ?>
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <img src="<?= base_url('uploads/kamar/' . $sewa['foto']) ?>" class="img-fluid rounded" alt="Kamar" style="object-fit: cover; height: 150px; width: 100%;">
                                </div>
                                <div class="col-md-8">
                                    <h4 class="fw-bold text-dark"><?= esc($sewa['nama_kamar']) ?></h4>
                                    <p class="text-muted mb-2"><i class="fas fa-calendar-alt me-2"></i> Mulai: <?= date('d M Y', strtotime($sewa['tanggal_masuk'])) ?></p>
                                    <p class="text-muted mb-3"><i class="fas fa-clock me-2"></i> Durasi: <?= $sewa['durasi_sewa'] ?> Bulan</p>

                                    <?php if ($sewa['status'] == 'Pending') : ?>
                                        <span class="status-badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i> Menunggu Konfirmasi Admin</span>
                                        <p class="small text-muted mt-2">Kami sedang memverifikasi pembayaran Anda.</p>
                                    <?php elseif ($sewa['status'] == 'Berjalan') : ?>
                                        <span class="status-badge bg-success text-white"><i class="fas fa-check-circle me-1"></i> Sewa Aktif</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-box-open fs-1 mb-3 opacity-50"></i>
                                <h5>Anda belum menyewa kamar apapun.</h5>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Ringkasan Tagihan -->
                <div class="card card-panel h-100">
                    <div class="card-body p-4 bg-light rounded" style="border: 1px solid #e2e8f0;">
                        <h5 class="fw-bold mb-4"><i class="fas fa-wallet text-primary me-2"></i> Ringkasan Biaya</h5>
                        <?php if ($sewa) : ?>
                            <div class="d-flex justify-content-between mb-3 text-muted">
                                <span>Total Tagihan</span>
                                <span class="fw-bold text-dark">Rp <?= number_format($sewa['total_tagihan'], 0, ',', '.') ?></span>
                            </div>
                            <hr class="opacity-25">
                            <div class="d-flex justify-content-between mb-0">
                                <span>Status</span>
                                <?php if ($sewa['status'] == 'Pending') : ?>
                                    <span class="fw-bold text-warning">Menunggu Cek</span>
                                <?php else : ?>
                                    <span class="fw-bold text-success">Lunas / Berjalan</span>
                                <?php endif; ?>
                            </div>
                        <?php else : ?>
                            <p class="text-muted small">Belum ada transaksi tercatat.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>