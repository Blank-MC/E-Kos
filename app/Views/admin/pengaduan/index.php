<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success shadow-sm"><i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('pesan'); ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger shadow-sm"><i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title fw-bold m-0">Daftar Pengaduan & Keluhan Penghuni</h3>
            </div>

            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Tanggal</th>
                            <th>Penghuni & Kamar</th>
                            <th>Judul & Isi Keluhan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengaduan)) : ?>
                            <?php $i = 1;
                            foreach ($pengaduan as $p) : ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($p['created_at'])); ?></td>
                                    <td>
                                        <span class="font-weight-bold text-primary"><?= esc($p['nama_penghuni']); ?></span><br>
                                        <small class="text-muted"><i class="fas fa-door-closed mr-1"></i> <?= esc($p['nama_kamar'] ?? 'Tidak ada kamar'); ?></small>
                                    </td>
                                    <td>
                                        <strong><?= esc($p['judul']); ?></strong><br>
                                        <small class="text-muted text-wrap" style="max-width: 300px; display: inline-block;">
                                            <?= esc(mb_strimwidth($p['isi'], 0, 50, '...')); ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($p['status'] == 'baru') : ?>
                                            <span class="badge badge-warning text-dark px-2 py-1">Baru</span>
                                        <?php elseif ($p['status'] == 'diproses') : ?>
                                            <span class="badge badge-info px-2 py-1">Diproses</span>
                                        <?php else : ?>
                                            <span class="badge badge-success px-2 py-1">Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#modalBalas<?= $p['id']; ?>">
                                            <i class="fas fa-reply mr-1"></i> Respon
                                        </button>
                                        <a href="<?= base_url('admin/pengaduan/delete/' . $p['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus riwayat pengaduan ini?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal Respon Pengaduan -->
                                <div class="modal fade" id="modalBalas<?= $p['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title font-weight-bold"><i class="fas fa-comment-dots mr-2"></i>Respon Pengaduan</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?= base_url('admin/pengaduan/update/' . $p['id']); ?>" method="POST">
                                                <?= csrf_field(); ?>
                                                <div class="modal-body text-left">
                                                    <div class="alert alert-light border mb-3">
                                                        <strong>Keluhan dari <?= esc($p['nama_penghuni']); ?>:</strong>
                                                        <p class="mb-0 mt-1 small text-muted"><?= esc($p['isi']); ?></p>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="font-weight-bold">Status Penanganan</label>
                                                        <select class="form-control" name="status">
                                                            <option value="baru" <?= $p['status'] == 'baru' ? 'selected' : ''; ?>>Baru</option>
                                                            <option value="diproses" <?= $p['status'] == 'diproses' ? 'selected' : ''; ?>>Sedang Diproses</option>
                                                            <option value="selesai" <?= $p['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai Ditangani</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="font-weight-bold">Balasan / Catatan Admin untuk Penghuni</label>
                                                        <textarea class="form-control" name="balasan_admin" rows="4" placeholder="Tulis tanggapan atau instruksi untuk penghuni..."><?= esc($p['balasan_admin'] ?? ''); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold">Simpan Respon</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada pengaduan dari penghuni.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>