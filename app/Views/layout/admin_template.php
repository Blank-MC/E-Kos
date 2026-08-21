<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'E-Kos | Hunian Nyaman Seperti Di Rumah' ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- FontAwesome Lokal -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <!-- AdminLTE CSS (Sudah include Bootstrap 4) -->
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap');

        :root {
            --primary: #0d9488;
            --primary-hover: #0f766e;
            --accent: #f59e0b;
            --accent-hover: #d97706;
            --dark: #1e293b;
            --light-bg: #f8fafc;
        }

        body {
            font-family: 'Quicksand', 'Source Sans Pro', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark);
        }

        /* Navbar Nyaman */
        .navbar-kos {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(13, 148, 136, 0.1);
            transition: all 0.3s ease;
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

        /* Hero Section Kos-kosan */
        .hero {
            padding: 140px 0 80px;
            background: linear-gradient(to bottom right, #f0fdfa, #ffffff);
            position: relative;
        }

        .hero-blob {
            position: absolute;
            top: -50px;
            right: 0;
            width: 450px;
            height: 450px;
            background: var(--primary);
            opacity: 0.05;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .highlight-text {
            color: var(--primary);
            position: relative;
            display: inline-block;
        }

        .highlight-text::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 12px;
            background: var(--accent);
            opacity: 0.3;
            z-index: -1;
            border-radius: 10px;
        }

        /* Card Tipe Kamar */
        .tipe-card {
            background: white;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tipe-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(13, 148, 136, 0.15);
        }

        .tipe-img {
            height: 220px;
            width: 100%;
            object-fit: cover;
            border-bottom: 4px solid var(--primary);
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .status-badge.penuh {
            background: #ef4444;
        }

        .btn-custom {
            background-color: var(--primary);
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 10px 25px;
            transition: 0.3s;
            border: none;
        }

        .btn-custom:hover {
            background-color: var(--primary-hover);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 700;
            border-radius: 12px;
            padding: 10px 25px;
            background: transparent;
            transition: 0.3s;
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
        }

        /* Fasilitas Bersama */
        .fasilitas-box {
            text-align: center;
            padding: 25px 15px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
            border: 1px solid #f1f5f9;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: #ccfbf1;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 15px;
        }

        /* Tambahan Utility Class agar sesuai dengan Bootstrap 4 AdminLTE */
        .gap-2 {
            gap: 0.5rem !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .gap-4 {
            gap: 1.5rem !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-kos fixed-top py-3">
        <div class="container">
            <a class="navbar-brand font-weight-bold d-flex align-items-center text-dark" href="<?= base_url() ?>" style="font-size: 1.5rem; gap: 0.5rem;">
                <i class="fas fa-door-open text-primary"></i>
                E-KOS
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-toggle="collapse" data-target="#navbarNav">
                <i class="fas fa-bars" style="font-size: 1.5rem;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kamar">Tipe Kamar</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fasilitas">Fasilitas Kos</a></li>
                </ul>
                <div class="d-flex mt-3 mt-lg-0" style="gap: 0.5rem;">
                    <a href="<?= base_url('login') ?>" class="btn btn-custom">Masuk Akun</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-blob"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3 font-weight-bold" style="font-size: 1rem;">
                        <i class="fas fa-star mr-1"></i> Kos Pria & Wanita (Beda Lantai)
                    </span>
                    <h1 class="display-4 font-weight-bold mb-3" style="line-height: 1.2;">
                        Kenyamanan Ngekos <br> Serasa di <span class="highlight-text">Rumah Sendiri</span>
                    </h1>
                    <p class="text-muted mb-5 pr-lg-4" style="font-size: 1.25rem;">Fasilitas lengkap, bersih, lingkungan aman, dan bebas jam malam (bawa kunci gerbang sendiri). Sangat cocok untuk mahasiswa dan karyawan.</p>

                    <div class="d-flex flex-wrap" style="gap: 1rem;">
                        <a href="#kamar" class="btn btn-custom btn-lg"><i class="fas fa-bed mr-2"></i> Lihat Tipe Kamar</a>
                        <a href="https://wa.me/6281234567890" class="btn btn-outline-custom btn-lg" target="_blank"><i class="fab fa-whatsapp mr-2"></i> Tanya Admin</a>
                    </div>

                    <div class="mt-5 d-flex align-items-center text-muted font-weight-bold" style="gap: 1.5rem;">
                        <div><i class="fas fa-wifi text-primary mr-2"></i> Free WiFi</div>
                        <div><i class="fas fa-broom text-primary mr-2"></i> Bersih</div>
                        <div><i class="fas fa-shield-alt text-primary mr-2"></i> Aman</div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <!-- Foto suasana kos-kosan -->
                    <div class="position-relative">
                        <img src="<?= base_url('uploads/hero-kos.jpg') ?>" onerror="this.src='https://images.unsplash.com/photo-1598928506311-c55ded91a20c?q=80&w=1000&auto=format&fit=crop'" class="img-fluid rounded-4 shadow-lg" alt="Suasana Kos" style="height: 450px; width: 100%; object-fit: cover; border: 8px solid white;">

                        <div class="position-absolute bg-white p-3 rounded-4 shadow" style="bottom: -20px; left: -30px;">
                            <div class="d-flex align-items-center" style="gap: 1rem;">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-check" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 font-weight-bold">Kamar Siap Huni</h6>
                                    <small class="text-muted">Tinggal bawa koper!</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Pilihan Kamar (DINAMIS DARI DATABASE) -->
    <section id="kamar" class="py-5 mt-4">
        <div class="container">
            <div class="text-center mb-5">
                <h5 class="text-primary font-weight-bold mb-2">Pilihan Kamar</h5>
                <h2 class="font-weight-bold m-0">Tipe Kamar di E-Kos</h2>
                <p class="text-muted mt-2">Pilih tipe kamar yang sesuai dengan kebutuhan dan budgetmu.</p>
            </div>

            <div class="row justify-content-center">

                <?php if (!empty($kamar)) : ?>
                    <?php foreach ($kamar as $k) : ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="tipe-card position-relative h-100">

                                <!-- Cek Status Kamar -->
                                <?php if ($k['status'] == 'Tersedia') : ?>
                                    <span class="status-badge"><i class="fas fa-check-circle mr-1"></i> Tersedia</span>
                                <?php else : ?>
                                    <span class="status-badge penuh"><i class="fas fa-times-circle mr-1"></i> Penuh</span>
                                <?php endif; ?>

                                <!-- Gambar Kamar -->
                                <img src="<?= base_url('uploads/kamar/' . $k['foto']) ?>" class="tipe-img" alt="<?= esc($k['nama_kamar']) ?>" onerror="this.src='https://via.placeholder.com/400x300?text=Kamar+Kos'">

                                <div class="card-body p-4">
                                    <h4 class="font-weight-bold mb-1 <?= $k['status'] != 'Tersedia' ? 'text-muted' : '' ?>"><?= esc($k['nama_kamar']) ?></h4>

                                    <p class="text-muted small mb-3"><i class="fas fa-ruler-combined mr-1"></i> Sesuai Standar</p>

                                    <!-- Placeholder Fasilitas Kamar -->
                                    <div class="row mb-4 text-muted small font-weight-bold">
                                        <div class="col-6 mb-2"><i class="fas fa-bed text-primary mr-2"></i> Kasur</div>
                                        <div class="col-6 mb-2"><i class="fas fa-door-open text-primary mr-2"></i> Lemari</div>
                                        <div class="col-6 mb-2"><i class="fas fa-plug text-primary mr-2"></i> Listrik Token</div>
                                        <div class="col-6 mb-2"><i class="fas fa-restroom text-primary mr-2"></i> Kamar Mandi</div>
                                    </div>

                                    <hr class="text-muted" style="opacity: 0.25;">

                                    <!-- Harga Kamar -->
                                    <h3 class="font-weight-bold <?= $k['status'] == 'Tersedia' ? 'text-primary' : 'text-muted' ?> mb-3">
                                        Rp <?= number_format($k['harga'], 0, ',', '.') ?><span class="text-muted font-weight-normal" style="font-size: 1rem;">/bln</span>
                                    </h3>

                                    <!-- Logika Tombol Pesan berdasarkan Status -->
                                    <?php if ($k['status'] == 'Tersedia') : ?>
                                        <a href="<?= base_url('kamar/detail/' . $k['id']) ?>" class="btn btn-custom btn-block">Lihat Detail & Pesan</a>
                                    <?php else : ?>
                                        <button class="btn btn-secondary btn-block font-weight-bold" disabled>Kamar Penuh</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-door-closed text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                        <h4 class="text-muted font-weight-bold">Data kamar belum tersedia.</h4>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- Fasilitas Bersama -->
    <section id="fasilitas" class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h5 class="text-primary font-weight-bold mb-2">Fasilitas Bersama</h5>
                <h2 class="font-weight-bold m-0">Yang Kamu Dapatkan di Luar Kamar</h2>
            </div>

            <div class="row">
                <div class="col-6 col-md-3 mb-4">
                    <div class="fasilitas-box h-100">
                        <div class="icon-circle"><i class="fas fa-utensils"></i></div>
                        <h6 class="font-weight-bold">Dapur Bersama</h6>
                        <small class="text-muted">Lengkap dengan kompor & kulkas luar.</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="fasilitas-box h-100">
                        <div class="icon-circle"><i class="fas fa-motorcycle"></i></div>
                        <h6 class="font-weight-bold">Parkir Motor Luas</h6>
                        <small class="text-muted">Aman di dalam gerbang kos.</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="fasilitas-box h-100">
                        <div class="icon-circle"><i class="fas fa-tshirt"></i></div>
                        <h6 class="font-weight-bold">Area Jemur</h6>
                        <small class="text-muted">Area jemur luas & terlindungi kanopi.</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="fasilitas-box h-100">
                        <div class="icon-circle"><i class="fas fa-video"></i></div>
                        <h6 class="font-weight-bold">CCTV 24 Jam</h6>
                        <small class="text-muted">Terpasang di lorong dan area parkir.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 text-center mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2026 E-Kos. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- JS Scripts dari project lu (AdminLTE & Bootstrap 4 lokal) -->
    <script src="<?= base_url('assets/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>

</html>