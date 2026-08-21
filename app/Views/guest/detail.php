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

        /* Navbar Nyaman */
        .navbar-kos {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(13, 148, 136, 0.1);
        }

        .nav-link {
            font-weight: 600;
            color: var(--dark) !important;
            margin: 0 12px;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* Detail Image */
        .detail-img-container {
            height: 400px;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 100px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
        }

        .detail-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Styling Content */
        .fasilitas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .fasilitas-item {
            background: white;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: var(--dark);
        }

        .fasilitas-item i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* Booking Card (Sticky) */
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-kos fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2 text-dark" href="<?= base_url() ?>">
                <i class="fas fa-door-open text-primary fs-3"></i> E-KOS
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars fs-3"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Detail Kamar</a></li>
                </ul>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <a href="<?= base_url('login') ?>" class="btn btn-outline-dark fw-bold" style="border-radius: 12px;">Masuk Akun</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Detail -->
    <div class="container pb-5">

        <!-- Gambar Kamar -->
        <div class="detail-img-container mb-4">
            <img src="<?= base_url('uploads/kamar/' . $kamar['foto']) ?>" alt="<?= esc($kamar['nama_kamar']) ?>" onerror="this.src='https://images.unsplash.com/photo-1598928506311-c55ded91a20c?q=80&w=1500&auto=format&fit=crop'">
        </div>

        <div class="row g-5">
            <!-- Kolom Kiri: Info Kamar -->
            <div class="col-lg-8">
                <!-- Header Title -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="mb-2">
                            <?php if ($kamar['status'] == 'Tersedia') : ?>
                                <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fas fa-check-circle me-1"></i> Tersedia</span>
                            <?php else : ?>
                                <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="fas fa-times-circle me-1"></i> Penuh</span>
                            <?php endif; ?>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill ms-2"><i class="fas fa-venus-mars text-primary me-1"></i> Campur</span>
                        </div>
                        <h1 class="fw-bold text-dark mb-1"><?= esc($kamar['nama_kamar']) ?></h1>
                        <p class="text-muted"><i class="fas fa-map-marker-alt text-danger me-2"></i>E-Kos Residence, Lantai 1</p>
                    </div>
                </div>

                <hr class="opacity-25 my-4">

                <!-- Deskripsi -->
                <h4 class="fw-bold mb-3">Deskripsi Kamar</h4>
                <p class="text-muted lh-lg">
                    Kamar luas dan nyaman, sangat cocok untuk kamu yang membutuhkan ketenangan setelah beraktivitas. Pencahayaan alami sangat bagus dengan ventilasi udara yang sehat. Tinggal bawa koper, semua sudah kami siapkan!
                </p>

                <hr class="opacity-25 my-4">

                <!-- Fasilitas Spesifik -->
                <h4 class="fw-bold mb-3">Fasilitas Kamar Ini</h4>
                <div class="fasilitas-grid">
                    <!-- Nanti ini bisa di-loop dari database relasi fasilitas -->
                    <div class="fasilitas-item"><i class="fas fa-bed"></i> Kasur Springbed</div>
                    <div class="fasilitas-item"><i class="fas fa-snowflake"></i> AC Dingin</div>
                    <div class="fasilitas-item"><i class="fas fa-door-open"></i> Lemari Baju</div>
                    <div class="fasilitas-item"><i class="fas fa-restroom"></i> Kamar Mandi Dalam</div>
                    <div class="fasilitas-item"><i class="fas fa-wifi"></i> WiFi Kencang</div>
                    <div class="fasilitas-item"><i class="fas fa-plug"></i> Listrik Token</div>
                </div>

                <hr class="opacity-25 my-4">

                <!-- Peraturan Singkat -->
                <h4 class="fw-bold mb-3">Peraturan Kos Singkat</h4>
                <ul class="text-muted lh-lg">
                    <li>Dilarang membawa hewan peliharaan.</li>
                    <li>Tamu lawan jenis dilarang masuk ke dalam kamar, disediakan ruang tamu.</li>
                    <li>Akses gerbang 24 jam (masing-masing penghuni pegang kunci).</li>
                </ul>
            </div>

            <!-- Kolom Kanan: Card Booking -->
            <div class="col-lg-4">
                <div class="booking-card">
                    <h5 class="fw-bold text-muted mb-2">Harga Sewa</h5>
                    <h2 class="fw-bold text-primary mb-0">Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></h2>
                    <p class="text-muted small">per bulan (belum termasuk token listrik)</p>

                    <hr class="opacity-25 my-4">

                    <!-- Ini rute sakti yang nanti ngarahin ke Form Pesan + Register -->
                    <?php if ($kamar['status'] == 'Tersedia') : ?>
                        <a href="<?= base_url('pesan/' . $kamar['id']) ?>" class="btn btn-custom w-100 d-block text-center mb-3">
                            <i class="fas fa-file-signature me-2"></i> Pesan & Buat Akun
                        </a>
                        <p class="text-center text-muted small mb-0"><i class="fas fa-info-circle me-1"></i> Pembayaran DP/Lunas dilakukan di tahap selanjutnya.</p>
                    <?php else : ?>
                        <button class="btn btn-secondary w-100 fw-bold py-3" disabled>Kamar Penuh, Coba Kamar Lain</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 text-center mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2026 E-Kos. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- JS BOOTSTRAP LOKAL -->
    <script src="<?= base_url('assets/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>