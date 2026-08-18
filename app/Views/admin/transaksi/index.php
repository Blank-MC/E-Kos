<?= $this->extend('layout/admin_template') ?>

<?= $this->section('sidebar_menu') ?>
<li class="nav-item"><a href="<?= base_url('admin') ?>" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/transaksi') ?>" class="nav-link active"><i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Transaksi & Tagihan</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success shadow-sm"><i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('pesan'); ?></div>
        <?php endif; ?>

        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">Validasi Pembayaran Tagihan Penghuni</h3>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th>Periode</th>
                            <th>Penghuni / Kamar</th>
                            <th>Jumlah</th>
                            <th class="text-center">Bukti Transfer</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi Validasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tagihan as $t) : ?>
                            <tr>
                                <td class="fw-bold"><?= esc($t['periode_bulan']); ?></td>
                                <td>
                                    <?= esc($t['nama_penghuni']); ?><br>
                                    <small class="text-muted"><?= esc($t['nama_kamar']); ?></small>
                                </td>
                                <td class="text-primary fw-bold">Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?></td>

                                <!-- Kolom Cek Bukti Transfer -->
                                <td class="text-center">
                                    <?php if (!empty($t['bukti_transfer'])) : ?>
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#buktiModal<?= $t['id']; ?>">
                                            <i class="fas fa-image"></i> Lihat Bukti
                                        </button>
                                    <?php else : ?>
                                        <span class="badge badge-secondary">Belum Upload</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($t['status'] == 'lunas') : ?>
                                        <span class="badge badge-success px-3 py-2">Lunas</span>
                                    <?php else : ?>
                                        <span class="badge badge-warning px-3 py-2">Menunggu Konfirmasi</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($t['status'] != 'lunas') : ?>
                                        <a href="<?= base_url('admin/transaksi/konfirmasi/' . $t['id']) ?>" class="btn btn-success btn-sm fw-bold" onclick="return confirm('Konfirmasi bahwa pembayaran ini sudah sah?');">
                                            <i class="fas fa-check-circle mr-1"></i> Setujui Lunas
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted small"><i class="fas fa-lock mr-1"></i> Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Modal Pop-up Lihat Bukti Transfer -->
                            <?php if (!empty($t['bukti_transfer'])) : ?>
                                <div class="modal fade" id="buktiModal<?= $t['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title fw-bold">Bukti Transfer - <?= esc($t['nama_penghuni']); ?></h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="<?= base_url('uploads/pembayaran/' . $t['bukti_transfer']) ?>" class="img-fluid rounded shadow-sm" alt="Bukti Transfer">
                                                <p class="mt-3 text-muted small">Tanggal Bayar: <?= esc($t['tgl_bayar'] ?? '-'); ?> | Metode: <?= esc($t['metode'] ?? 'Transfer'); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>