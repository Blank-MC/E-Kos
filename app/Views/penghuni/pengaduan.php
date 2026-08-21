<?= $this->extend('layout/penghuni_template') ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-12">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Form Kirim Keluhan Baru -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold m-0 text-dark"><i class="fas fa-edit text-primary me-2"></i>Tulis Keluhan / Pengaduan</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-4">Laporkan kerusakan fasilitas atau kendala kenyamanan di lingkungan kos langsung ke pihak pengelola.</p>
                <form action="<?= base_url('penghuni/pengaduan/store'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul / Pokok Masalah</label>
                        <input type="text" class="form-control" name="judul" placeholder="Contoh: AC Kamar Bocor / Lampu Redup" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Detail Keluhan</label>
                        <textarea class="form-control" name="isi" rows="5" placeholder="Jelaskan detail keluhan atau kendala Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-teal text-white w-100 fw-bold py-2 rounded-3">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Pengaduan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Riwayat Status Pengaduan -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                <h5 class="fw-bold m-0 text-dark"><i class="fas fa-history text-primary me-2"></i>Riwayat Pengaduan</h5>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($pengaduan)) : ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($pengaduan as $item) : ?>
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-dark"><?= esc($item['judul']); ?></h6>
                                    <?php if ($item['status'] == 'baru') : ?>
                                        <span class="badge bg-warning text-dark px-3 py-1">Menunggu Respon</span>
                                    <?php elseif ($item['status'] == 'diproses') : ?>
                                        <span class="badge bg-info px-3 py-1">Sedang Diproses</span>
                                    <?php else : ?>
                                        <span class="badge bg-success px-3 py-1">Selesai</span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-muted small mb-2"><?= esc($item['isi']); ?></p>
                                <small class="text-secondary d-block"><i class="far fa-clock me-1"></i> <?= date('d M Y - H:i', strtotime($item['created_at'])); ?> WIB</small>

                                <?php if (!empty($item['balasan_admin'])) : ?>
                                    <div class="mt-3 p-3 bg-white border rounded-3">
                                        <div class="fw-bold small text-primary mb-1"><i class="fas fa-reply me-1"></i> Respon Pengelola:</div>
                                        <p class="small text-dark mb-0"><?= esc($item['balasan_admin']); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-clipboard-check fa-3x mb-3 text-secondary opacity-50"></i>
                        <p class="mb-0">Belum ada riwayat keluhan yang dikirimkan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>