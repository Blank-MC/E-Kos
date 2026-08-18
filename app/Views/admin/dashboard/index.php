<?= $this->extend('layout/admin_template') ?>

<!-- ================= START SIDEBAR MENU ================= -->
<?= $this->section('sidebar_menu') ?>
<li class="nav-item">
    <a href="<?= base_url('admin') ?>" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<!-- Menu lainnya sengaja dibiarkan mati dulu, nanti kita hidupkan satu per satu -->
<li class="nav-item">
    <a href="#" class="nav-link text-muted">
        <i class="nav-icon fas fa-door-open"></i>
        <p>Kelola Kamar</p>
    </a>
</li>
<?= $this->endSection() ?>
<!-- ================= END SIDEBAR MENU ================= -->

<!-- ================= START KONTEN UTAMA ================= -->
<?= $this->section('content') ?>
<div class="row">
    <!-- Box Total Kamar -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3><?= $total_kamar; ?></h3>
                <p>Total Kamar</p>
            </div>
            <div class="icon"><i class="fas fa-bed"></i></div>
            <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box Kamar Terisi -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3><?= $kamar_terisi; ?></h3>
                <p>Kamar Terisi</p>
            </div>
            <div class="icon"><i class="fas fa-user-check"></i></div>
            <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box Kamar Kosong -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3><?= $kamar_kosong; ?></h3>
                <p>Kamar Kosong</p>
            </div>
            <div class="icon"><i class="fas fa-door-open"></i></div>
            <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box Pendapatan -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary shadow-sm">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup> <?= number_format($pendapatan_bulan_ini, 0, ',', '.'); ?></h3>
                <p>Pendapatan Bulan Ini</p>
            </div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            <a href="#" class="small-box-footer">Ke Laporan <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Area Grafik -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title fw-bold">Grafik Pendapatan Tahun Ini</h3>
            </div>
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-chart-bar fa-4x mb-3 text-light"></i>
                <h5>Area Grafik Chart.js</h5>
                <p class="small">Grafik akan dirender di sini setelah data transaksi beroperasi penuh.</p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<!-- ================= END KONTEN UTAMA ================= -->