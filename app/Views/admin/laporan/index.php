<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title fw-bold m-0">Rekap Pendapatan Lunas</h3>
        <div>
            <a href="<?= base_url('admin/laporan/excel') ?>" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel mr-1"></i> Export Excel
            </a>
            <a href="<?= base_url('admin/laporan/pdf') ?>" target="_blank" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF / Cetak
            </a>
        </div>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle text-nowrap">
            <thead class="bg-light">
                <tr>
                    <th class="text-center" style="width: 60px;">No</th>
                    <th>Periode</th>
                    <th>Penghuni</th>
                    <th>Kamar</th>
                    <th>Jumlah Masuk</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pendapatan)) : ?>
                    <?php $no = 1;
                    foreach ($pendapatan as $p) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="fw-bold"><?= esc($p['periode_bulan']); ?></td>
                            <td><?= esc($p['nama_penghuni'] ?? '-'); ?></td>
                            <td><?= esc($p['nama_kamar'] ?? '-'); ?></td>
                            <td class="text-success fw-bold">Rp <?= number_format($p['jumlah'], 0, ',', '.'); ?></td>
                            <td class="text-center"><span class="badge badge-success">Lunas</span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada pendapatan yang tercatat lunas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>