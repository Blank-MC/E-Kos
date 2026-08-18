<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title : 'Dashboard E-Kos' ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar Atas -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="#">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar Utama -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="<?= base_url('admin') ?>" class="brand-link text-center">
                <span class="brand-text font-weight-bold">E-KOS PANEL</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <div class="bg-secondary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <i class="fas fa-user-shield text-sm"></i>
                        </div>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block text-white">Administrator</a>
                    </div>
                </div>

                <!-- MENU SIDEBAR GABUNGAN (Otomatis Aktif Sesuai URL) -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="<?= base_url('admin') ?>" class="nav-link <?= service('uri')->getSegment(2) == '' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('admin/kamar') ?>" class="nav-link <?= service('uri')->getSegment(2) == 'kamar' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-door-open"></i>
                                <p>Data Kamar</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('admin/fasilitas') ?>" class="nav-link <?= service('uri')->getSegment(2) == 'fasilitas' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Data Fasilitas</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('admin/penghuni') ?>" class="nav-link <?= service('uri')->getSegment(2) == 'penghuni' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Data Penghuni</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('admin/sewa') ?>" class="nav-link <?= service('uri')->getSegment(2) == 'sewa' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-clipboard-check"></i>
                                <p>Pengajuan Sewa</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('admin/transaksi') ?>" class="nav-link <?= service('uri')->getSegment(2) == 'transaksi' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>Transaksi & Tagihan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('admin/laporan') ?>" class="nav-link <?= service('uri')->getSegment(2) == 'laporan' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Laporan Pendapatan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('admin/pengaturan') ?>" class="nav-link <?= service('uri')->getSegment(2) == 'pengaturan' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Pengaturan Kos</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Area Konten Utama -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 fw-bold"><?= isset($title) ? $title : 'Blank Page' ?></h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </section>
        </div>

        <footer class="main-footer text-sm">
            <strong>Copyright &copy; 2026 E-Kos.</strong> All rights reserved.
        </footer>
    </div>

    <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>

</html>