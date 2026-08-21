<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>

    <!-- BOOTSTRAP 5 LOKAL -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- FontAwesome Lokal -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap">

    <style>
        :root {
            --primary: #0d9488;
            --primary-hover: #0f766e;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light-bg: #f8fafc;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark);
        }

        /* Navbar Konsisten dengan Beranda */
        .navbar-kos {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(13, 148, 136, 0.1);
        }

        .nav-link {
            font-weight: 600;
            color: var(--dark) !important;
            margin: 0 12px;
            font-size: 1.05rem;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* Carousel Slider Multi-Foto Full & Menyesuaikan */
        .detail-carousel {
            margin-top: 100px;
            border-radius: 20px;
            overflow: hidden;
            background-color: #000;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .carousel-item img {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            border-radius: 20px;
        }

        /* Fasilitas Grid */
        .fasilitas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
        }

        .fasilitas-item {
            background: white;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            color: var(--dark);
        }

        .fasilitas-item i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* Booking Card */
        .booking-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(13, 148, 136, 0.08);
            position: sticky;
            top: 100px;
        }

        .btn-custom {
            background-color: var(--primary);
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px;
            transition: 0.3s;
            border: none;
        }

        .btn-custom:hover {
            background-color: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <!-- Navbar yang Disamakan dengan Dashboard Guest -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-kos fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2 text-dark" href="<?= base_url() ?>">
                <i class="fas fa-door-open text-primary fs-3"></i> <?= esc($pengaturan['nama_kos'] ?? 'E-KOS') ?>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars fs-3"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/#kamar') ?>">Tipe Kamar</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/#fasilitas') ?>">Fasilitas Kos</a></li>
                </ul>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <a href="<?= base_url('login') ?>" class="btn btn-custom px-4">Masuk Akun</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Detail -->
    <div class="container pb-5">

        <!-- Multi-Foto / Carousel Slider -->
        <div id="kamarCarousel" class="carousel slide detail-carousel mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Foto Utama -->
                <div class="carousel-item active">
                    <img src="<?= base_url('uploads/kamar/' . ($kamar['foto_utama'] ?? 'default.jpg')) ?>" class="d-block w-100" alt="Foto Utama Kamar" onerror="this.src='https://images.unsplash.com/photo-1598928506311-c55ded91a20c?q=80&w=1500&auto=format&fit=crop'">
                </div>
                <!-- Foto Tambahan dari tabel kamar_foto -->
                <?php if (!empty($galeriFoto)) : ?>
                    <?php foreach ($galeriFoto as $galeri) : ?>
                        <div class="carousel-item">
                            <img src="<?= base_url('uploads/kamar/galeri/' . $galeri['file_foto']) ?>" class="d-block w-100" alt="Galeri Kamar" onerror="this.src='https://images.unsplash.com/photo-1598928506311-c55ded91a20c?q=80&w=1500&auto=format&fit=crop'">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($galeriFoto)) : ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#kamarCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#kamarCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            <?php endif; ?>
        </div>

        <div class="row g-5">
            <!-- Kolom Kiri: Info Kamar -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="mb-2">
                            <?php if ($kamar['status'] == 'kosong') : ?>
                                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i> Tersedia</span>
                            <?php elseif ($kamar['status'] == 'terisi') : ?>
                                <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i> Penuh</span>
                            <?php else : ?>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fas fa-tools me-1"></i> Maintenance</span>
                            <?php endif; ?>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill ms-2"><i class="fas fa-door-open text-primary me-1"></i> Tipe: <?= esc($kamar['tipe'] ?? 'Standard') ?></span>
                        </div>
                        <h1 class="fw-bold text-dark mb-1"><?= esc($kamar['nama_kamar']) ?></h1>
                        <p class="text-muted"><i class="fas fa-map-marker-alt text-danger me-2"></i><?= esc($pengaturan['nama_kos'] ?? 'E-Kos') ?> | Ukuran: <?= esc($kamar['ukuran'] ?? 'Standard') ?></p>
                    </div>
                </div>

                <hr class="opacity-25 my-4">

                <!-- Deskripsi -->
                <h4 class="fw-bold mb-3">Deskripsi Kamar</h4>
                <p class="text-muted lh-lg">
                    <?= esc($kamar['deskripsi'] ?? 'Kamar luas dan nyaman, sangat cocok untuk kamu yang membutuhkan ketenangan setelah beraktivitas.') ?>
                </p>

                <hr class="opacity-25 my-4">

                <!-- Fasilitas Kamar dari Database -->
                <h4 class="fw-bold mb-3">Fasilitas Kamar Ini</h4>
                <div class="fasilitas-grid">
                    <?php if (!empty($fasilitas)) : ?>
                        <?php foreach ($fasilitas as $fas) : ?>
                            <div class="fasilitas-item">
                                <i class="<?= esc($fas['icon'] ?? 'fas fa-check-circle') ?>"></i>
                                <span><?= esc($fas['nama_fasilitas']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-muted">Fasilitas standar tersedia.</p>
                    <?php endif; ?>
                </div>

                <hr class="opacity-25 my-4">

                <!-- Peraturan Singkat -->
                <h4 class="fw-bold mb-3">Peraturan Kos</h4>
                <ul class="text-muted lh-lg">
                    <li><?= esc($pengaturan['peraturan'] ?? 'Dilarang membawa hewan peliharaan dan wajib menjaga ketertiban bersama.') ?></li>
                </ul>
            </div>

            <!-- Kolom Kanan: Card Booking -->
            <div class="col-lg-4">
                <div class="booking-card">
                    <h5 class="fw-bold text-muted mb-2">Harga Sewa</h5>
                    <h2 class="fw-bold text-primary mb-0">Rp <?= number_format($kamar['harga_bulanan'], 0, ',', '.') ?></h2>
                    <p class="text-muted small">per bulan</p>

                    <hr class="opacity-25 my-4">

                    <?php if ($kamar['status'] == 'kosong') : ?>
                        <a href="<?= base_url('pesan/' . $kamar['id']) ?>" class="btn btn-custom w-100 d-block text-center mb-3">
                            <i class="fas fa-file-signature me-2"></i> Pesan & Buat Akun
                        </a>
                        <p class="text-center text-muted small mb-0"><i class="fas fa-info-circle me-1"></i> Pengajuan sewa akan diverifikasi oleh Admin.</p>
                    <?php elseif ($kamar['status'] == 'terisi') : ?>
                        <button class="btn btn-secondary w-100 fw-bold py-3" disabled>Kamar Penuh</button>
                    <?php else : ?>
                        <button class="btn btn-warning w-100 fw-bold py-3" disabled>Sedang Perbaikan</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-light small">&copy; 2026 <strong><?= esc($pengaturan['nama_kos'] ?? 'E-Kos') ?></strong>. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- JS BOOTSTRAP LOKAL -->
    <script src="<?= base_url('assets/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>