<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Panel Penghuni | E-Kos'); ?></title>

    <!-- BOOTSTRAP 5 LOKAL -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <!-- FontAwesome Lokal -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css'); ?>">
    <!-- Google Font -->
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-penghuni {
            background-color: #ffffff;
            border-bottom: 1px solid rgba(13, 148, 136, 0.15);
        }

        .nav-link {
            font-weight: 600;
            color: #475569 !important;
            margin: 0 5px;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary) !important;
            background-color: rgba(13, 148, 136, 0.08);
        }

        .main-wrapper {
            flex: 1;
            padding-top: 90px;
            padding-bottom: 40px;
        }

        .card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
        }

        .btn-teal {
            background-color: var(--primary);
            color: #ffffff;
            border: none;
        }

        .btn-teal:hover {
            background-color: var(--primary-hover);
            color: #ffffff;
        }
    </style>
</head>

<body>

    <!-- Header / Navbar Penghuni -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-penghuni fixed-top shadow-sm py-2">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-2 text-dark" href="<?= base_url('penghuni/dashboard'); ?>">
                <i class="fas fa-door-open text-primary fs-3"></i> <?= esc($pengaturan['nama_kos'] ?? 'E-KOS'); ?>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPenghuni">
                <i class="fas fa-bars fs-4"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarPenghuni">
                <ul class="navbar-nav mx-auto align-items-lg-center my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == 'penghuni/dashboard' ? 'active' : ''; ?>" href="<?= base_url('penghuni/dashboard'); ?>">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'penghuni/tagihan') !== false ? 'active' : ''; ?>" href="<?= base_url('penghuni/tagihan'); ?>">
                            <i class="fas fa-receipt me-1"></i> Tagihan Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'penghuni/pengaduan') !== false ? 'active' : ''; ?>" href="<?= base_url('penghuni/pengaduan'); ?>">
                            <i class="fas fa-bullhorn me-1"></i> Pengaduan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'penghuni/profil') !== false ? 'active' : ''; ?>" href="<?= base_url('penghuni/profil'); ?>">
                            <i class="fas fa-user-circle me-1"></i> Profil
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <span class="d-none d-lg-inline text-muted small fw-semibold">
                        <i class="fas fa-user me-1 text-primary"></i> <?= esc(session()->get('nama') ?? 'Penghuni'); ?>
                    </span>
                    <a href="<?= base_url('logout'); ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3 font-weight-bold" onclick="return confirm('Apakah Anda yakin ingin keluar?');">
                        <i class="fas fa-sign-out-alt me-1"></i> Keluar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <main class="main-wrapper">
        <div class="container">
            <?= $this->renderSection('content'); ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 text-center text-muted small mt-auto">
        <div class="container">
            <p class="mb-0">&copy; 2026 <strong><?= esc($pengaturan['nama_kos'] ?? 'E-Kos'); ?></strong>. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- JS Lokal (jQuery & Bootstrap Bundle) -->
    <script src="<?= base_url('assets/jquery/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>

</html>