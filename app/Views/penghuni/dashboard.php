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
        <div class="card card-outline card-warning shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="card-title fw-bold m-0 text-dark"><i class="fas fa-file-invoice-dollar text-warning mr-2"></i>Tagihan Terkini</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <?php if (!empty($tagihan)) : ?>
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <small class="text-muted">Periode Tagihan</small>
                                <h4 class="fw-bold mb-0"><?= esc($tagihan['periode_bulan']); ?></h4>
                            </div>
                            <div>
                                <?php if ($tagihan['status'] == 'lunas') : ?>
                                    <span class="badge badge-success px-3 py-2">LUNAS</span>
                                <?php elseif ($tagihan['status'] == 'menunggu_konfirmasi') : ?>
                                    <span class="badge badge-info px-3 py-2">MENUNGGU KONFIRMASI</span>
                                <?php else : ?>
                                    <span class="badge badge-danger px-3 py-2">BELUM BAYAR</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded mb-3 border">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Total Jumlah</span>
                                <span class="fw-bold text-dark fs-5">Rp <?= number_format($tagihan['jumlah'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Jatuh Tempo</span>
                                <span class="fw-bold text-danger"><?= date('d F Y', strtotime($tagihan['tgl_jatuh_tempo'])); ?></span>
                            </div>
                        </div>

                        <!-- Banner Durasi Sisa Waktu Jatuh Tempo -->
                        <?php if (!empty($tenggat_info)) : ?>
                            <?php if ($tenggat_info['status'] == 'terlambat') : ?>
                                <div class="alert alert-danger mb-3 shadow-sm border-0">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <strong>Perhatian!</strong> Pembayaran Anda <?= $tenggat_info['teks']; ?>.
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning mb-3 shadow-sm border-0 text-dark">
                                    <i class="fas fa-clock mr-1"></i>
                                    <strong>Batas Pembayaran:</strong> <?= $tenggat_info['teks']; ?>.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div>
                        <a href="<?= base_url('penghuni/tagihan'); ?>" class="btn btn-teal text-white w-100 font-weight-bold" style="background-color: #0d9488;">
                            <i class="fas fa-receipt mr-1"></i> Lihat Rincian & Bayar
                        </a>
                    </div>
                <?php else : ?>
                    <div class="text-center py-5 text-muted my-auto">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <p class="mb-0">Tidak ada tagihan aktif saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>