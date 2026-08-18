<?= $this->extend('layout/admin_template') ?>
<?= $this->section('sidebar_menu') ?>
<li class="nav-item"><a href="<?= base_url('admin') ?>" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/kamar') ?>" class="nav-link"><i class="nav-icon fas fa-door-open"></i>
        <p>Kelola Kamar</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/fasilitas') ?>" class="nav-link"><i class="nav-icon fas fa-tags"></i>
        <p>Data Fasilitas</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/penghuni') ?>" class="nav-link"><i class="nav-icon fas fa-users"></i>
        <p>Data Penghuni</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/sewa') ?>" class="nav-link active"><i class="nav-icon fas fa-clipboard-check"></i>
        <p>Pengajuan Sewa</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/transaksi') ?>" class="nav-link"><i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Transaksi & Tagihan</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline shadow-sm">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle text-nowrap">
            <thead class="bg-light">
                <tr>
                    <th>Calon Penghuni</th>
                    <th>Kamar</th>
                    <th>Mulai & Durasi</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sewa as $s) : ?>
                    <tr>
                        <td class="fw-bold"><?= esc($s['nama_penghuni']); ?><br><small class="text-muted"><?= esc($s['no_hp']); ?></small></td>
                        <td><?= esc($s['nama_kamar']); ?></td>
                        <td><?= esc($s['tgl_mulai']); ?><br><small class="text-muted"><?= esc($s['durasi_bulan']); ?> Bulan</small></td>
                        <td class="text-center">
                            <?php if ($s['status'] == 'pending') : ?><span class="badge badge-warning">Pending</span>
                            <?php elseif ($s['status'] == 'aktif') : ?><span class="badge badge-success">Aktif</span>
                            <?php else : ?><span class="badge badge-danger">Ditolak</span><?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($s['status'] == 'pending') : ?>
                                <a href="<?= base_url('admin/sewa/status/' . $s['id'] . '/aktif') ?>" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approve</a>
                                <a href="<?= base_url('admin/sewa/status/' . $s['id'] . '/ditolak') ?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Reject</a>
                            <?php else : ?>
                                <span class="text-muted small">Selesai/Terkunci</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>