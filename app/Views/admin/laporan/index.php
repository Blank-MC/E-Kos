<?= $this->extend('layout/admin_template') ?>
<?= $this->section('sidebar_menu') ?>
<li class="nav-item"><a href="<?= base_url('admin/laporan') ?>" class="nav-link active"><i class="nav-icon fas fa-chart-bar"></i>
        <p>Laporan Pendapatan</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/pengaturan') ?>" class="nav-link"><i class="nav-icon fas fa-cog"></i>
        <p>Pengaturan Kos</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title fw-bold">Rekap Pendapatan Lunas</h3>
        <div>
            <button class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export Excel</button>
            <button class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</button>
        </div>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle text-nowrap">
            <thead class="bg-light">
                <tr>
                    <th>Periode</th>
                    <th>Jumlah Masuk</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendapatan as $p) : ?>
                    <tr>
                        <td><?= esc($p['periode_bulan']); ?></td>
                        <td class="text-success fw-bold">Rp <?= number_format($p['jumlah'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>