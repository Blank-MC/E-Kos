<?= $this->extend('layout/penghuni_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Ucapan Selamat Datang -->
    <div class="col-12 mb-4">
        <div class="card bg-gradient-primary text-white shadow-sm border-0" style="background: linear-gradient(135deg, #0d9488, #0f766e);">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-1">Halo, <?= esc(session()->get('nama') ?? 'Penghuni'); ?>! 👋</h3>
                <p class="mb-0 text-white-50">Selamat datang di panel penghuni <strong><?= esc($pengaturan['nama_kos'] ?? 'E-Kos'); ?></strong>.</p>
            </div>
        </div>
    </div>

    <!-- Kolom Kiri: Informasi Kamar Aktif -->
    <div class="col-lg-6 mb-4">
        <div class="card card-outline card-teal shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="card-title fw-bold m-0 text-dark"><i class="fas fa-bed text-primary mr-2"></i>Kamar Saya</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($sewa)) : ?>
                    <div class="text-center mb-3">
                        <img src="<?= base_url('uploads/kamar/' . ($sewa['foto_utama'] ?? 'default.jpg')) ?>" class="img-fluid rounded shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;" alt="Foto Kamar" onerror="this.src='https://via.placeholder.com/400x250?text=Kamar+Kos'">
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Nama Kamar</span>
                            <span class="fw-bold fs-5 text-dark"><?= esc($sewa['nama_kamar']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Biaya Bulanan</span>
                            <span class="fw-bold text-primary">Rp <?= number_format($sewa['harga_bulanan'] ?? 0, 0, ',', '.'); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Mulai Sewa</span>
                            <span><?= date('d F Y', strtotime($sewa['tgl_mulai'])); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Durasi Sewa</span>
                            <span><?= esc($sewa['durasi_bulan']); ?> Bulan</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Status Sewa</span>
                            <?php if (($sewa['status'] ?? '') == 'aktif') : ?>
                                <span class="badge bg-success px-3 py-2">Aktif</span>
                            <?php elseif (($sewa['status'] ?? '') == 'pending') : ?>
                                <span class="badge bg-warning text-dark px-3 py-2">Menunggu Konfirmasi</span>
                            <?php elseif (($sewa['status'] ?? '') == 'ditolak') : ?>
                                <span class="badge bg-danger px-3 py-2">Ditolak</span>
                            <?php else : ?>
                                <span class="badge bg-secondary px-3 py-2"><?= ucfirst($sewa['status'] ?? 'Menunggu'); ?></span>
                            <?php endif; ?>
                        </li>
                    </ul>
                <?php else : ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-door-closed fa-3x mb-3 text-secondary"></i>
                        <p class="mb-0">Anda belum terdaftar pada kamar sewa manapun.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Status Tagihan Terkini & Tenggat Pembayaran -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm h-100 border-0" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold m-0 text-dark"><i class="fas fa-file-invoice-dollar text-warning me-2"></i>Tagihan Terkini</h5>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <?php if (!empty($tagihan)) : ?>
                    <?php
                    $today = new \DateTime(date('Y-m-d'));
                    $due = new \DateTime($tagihan['tgl_jatuh_tempo']);
                    $diff = $today->diff($due);
                    $is_expired = ($today > $due);
                    $sisa_hari = $diff->days;
                    ?>
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <small class="text-muted">Periode Tagihan</small>
                                <h4 class="fw-bold mb-0"><?= esc($tagihan['periode_bulan']); ?></h4>
                            </div>
                            <div>
                                <?php if ($tagihan['status'] == 'lunas') : ?>
                                    <span class="badge bg-success px-3 py-2">LUNAS</span>
                                <?php elseif ($tagihan['status'] == 'menunggu_konfirmasi') : ?>
                                    <span class="badge bg-info px-3 py-2">MENUNGGU KONFIRMASI</span>
                                <?php else : ?>
                                    <span class="badge bg-danger px-3 py-2">BELUM BAYAR</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-4 mb-3 border">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Tagihan</span>
                                <span class="fw-bold text-dark fs-5">Rp <?= number_format($tagihan['jumlah'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Jatuh Tempo</span>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-danger"><?= date('d F Y', strtotime($tagihan['tgl_jatuh_tempo'])); ?></span>
                                    <?php if ($tagihan['status'] != 'lunas') : ?>
                                        <?php if ($is_expired) : ?>
                                            <span class="badge bg-danger text-white px-2 py-1">Telat <?= $sisa_hari; ?> Hari</span>
                                        <?php else : ?>
                                            <span class="badge bg-warning text-dark px-2 py-1"><?= $sisa_hari; ?> Hari Lagi</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Banner Peringatan -->
                        <?php if ($tagihan['status'] != 'lunas') : ?>
                            <?php if ($is_expired) : ?>
                                <div class="alert alert-danger mb-3 border-0 rounded-3 shadow-sm">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    <strong>Perhatian!</strong> Pembayaran Anda sudah lewat tenggat waktu <strong><?= $sisa_hari; ?> hari</strong>. Harap segera lakukan pelunasan.
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning mb-3 border-0 rounded-3 text-dark shadow-sm">
                                    <i class="fas fa-clock me-1"></i>
                                    Batas waktu pembayaran tersisa <strong><?= $sisa_hari; ?> hari lagi</strong>.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div>
                        <a href="<?= base_url('penghuni/tagihan'); ?>" class="btn btn-teal text-white w-100 py-2 fw-bold rounded-3">
                            <i class="fas fa-receipt me-1"></i> Lihat Rincian & Bayar
                        </a>
                    </div>
                <?php else : ?>
                    <div class="text-center py-5 text-muted my-auto">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                        <p class="mb-0">Tidak ada tagihan yang harus dibayar saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>