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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(13, 148, 136, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }

        .login-img {
            background: linear-gradient(rgba(13, 148, 136, 0.7), rgba(13, 148, 136, 0.8)), url('<?= base_url("uploads/hero-kos.jpg") ?>');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.25);
        }

        .btn-login {
            background-color: #0d9488;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #0f766e;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="login-card mx-auto">
            <div class="row g-0">
                <!-- Kolom Kiri: Gambar -->
                <div class="col-md-6 d-none d-md-block">
                    <div class="login-img">
                        <h2 class="fw-bold mb-3"><i class="fas fa-door-open mb-3 fs-1 d-block"></i>E-KOS</h2>
                        <p class="fs-5">Manajemen kos jadi lebih mudah, transparan, dan aman. Silakan masuk ke akun Anda.</p>
                    </div>
                </div>

                <!-- Kolom Kanan: Form Login -->
                <div class="col-md-6">
                    <div class="p-5">
                        <div class="text-center mb-4 d-md-none">
                            <h2 class="fw-bold text-teal"><i class="fas fa-door-open text-primary"></i> E-KOS</h2>
                        </div>
                        <h3 class="fw-bold mb-1">Selamat Datang!</h3>
                        <p class="text-muted mb-4">Silakan masukkan email dan password Anda.</p>

                        <!-- Tampilkan Error/Pesan -->
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger rounded-3 small"><i class="fas fa-exclamation-circle me-1"></i> <?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('pesan')) : ?>
                            <div class="alert alert-success rounded-3 small"><i class="fas fa-check-circle me-1"></i> <?= session()->getFlashdata('pesan') ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('auth/proses') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="fw-bold small mb-2">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0" name="email" placeholder="Masukkan email Anda" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="fw-bold small mb-2">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" class="form-control border-start-0" name="password" placeholder="Masukkan password Anda" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-login"><i class="fas fa-sign-in-alt me-2"></i> Masuk Sekarang</button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="<?= base_url() ?>" class="text-decoration-none text-muted small fw-bold"><i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>