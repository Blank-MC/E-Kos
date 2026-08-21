<?= $this->extend('layout/penghuni_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('pesan'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
                <h5 class="fw-bold m-0 text-dark"><i class="fas fa-receipt text-primary me-2"></i>Daftar Tagihan & Riwayat Pembayaran</h5>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle text-nowrap mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center ps-4" style="width: 50px;">No</th>
                            <th>Periode</th>
                            <th>Kamar</th>
                            <th>Jumlah</th>
                            <th>Jatuh Tempo & Sisa Hari</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-4" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tagihan)) : ?>
                            <?php $i = 1;
                            foreach ($tagihan as $t) : ?>
                                <tr>
                                    <td class="text-center ps-4"><?= $i++; ?></td>
                                    <td class="fw-bold"><?= esc($t['periode_bulan']); ?></td>
                                    <td><?= esc($t['nama_kamar'] ?? '-'); ?></td>
                                    <td class="fw-bold text-dark">Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php
                                        $today = new \DateTime(date('Y-m-d'));
                                        $due = new \DateTime($t['tgl_jatuh_tempo']);
                                        $diff = $today->diff($due);
                                        $is_expired = ($today > $due);
                                        $sisa_hari = $diff->days;
                                        ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-dark fw-medium">
                                                <i class="far fa-calendar-alt text-muted me-1"></i> <?= date('d M Y', strtotime($t['tgl_jatuh_tempo'])); ?>
                                            </span>

                                            <?php if ($is_expired) : ?>
                                                <span class="badge bg-danger text-white px-2 py-1"><i class="fas fa-exclamation-circle me-1"></i>Terlambat <?= $sisa_hari; ?> Hari</span>
                                            <?php elseif ($sisa_hari == 0) : ?>
                                                <span class="badge bg-danger text-white px-2 py-1"><i class="fas fa-exclamation-triangle me-1"></i>Hari Ini Terakhir</span>
                                            <?php else : ?>
                                                <span class="badge bg-warning text-dark px-2 py-1"><i class="fas fa-clock me-1"></i><?= $sisa_hari; ?> Hari Lagi</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($t['status'] == 'lunas') : ?>
                                            <span class="badge bg-success text-white px-3 py-2"><i class="fas fa-check me-1"></i> Lunas</span>
                                        <?php elseif ($t['status'] == 'menunggu_konfirmasi') : ?>
                                            <span class="badge bg-info text-white px-3 py-2"><i class="fas fa-hourglass-half me-1"></i> Menunggu Konfirmasi</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger text-white px-3 py-2"><i class="fas fa-times me-1"></i> Belum Bayar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <?php if ($t['status'] == 'lunas' || $t['status'] == 'menunggu_konfirmasi') : ?>
                                            <?php if (!empty($t['bukti_transfer'])) : ?>
                                                <a href="<?= base_url('uploads/bukti/' . $t['bukti_transfer']); ?>" target="_blank" class="btn btn-outline-info btn-sm rounded-pill px-3">
                                                    <i class="fas fa-eye me-1"></i> Bukti
                                                </a>
                                            <?php else : ?>
                                                <span class="text-muted small">-</span>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <button type="button" class="btn btn-teal text-white btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalBayar<?= $t['id']; ?>">
                                                <i class="fas fa-upload me-1"></i> Bayar
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Modal Form Upload Bukti Pembayaran -->
                                <?php if ($t['status'] == 'belum_bayar' || $t['status'] == 'terlambat') : ?>
                                    <div class="modal fade" id="modalBayar<?= $t['id']; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                                                <div class="modal-header text-white" style="background-color: #0d9488; border-radius: 16px 16px 0 0;">
                                                    <h5 class="modal-title fw-bold"><i class="fas fa-wallet me-2"></i>Konfirmasi Pembayaran</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?= base_url('penghuni/tagihan/bayar'); ?>" method="POST" enctype="multipart/form-data">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="id_tagihan" value="<?= $t['id']; ?>">

                                                    <div class="modal-body text-start p-4">
                                                        <div class="alert alert-light border mb-3 rounded-3">
                                                            <div class="d-flex justify-content-between mb-1">
                                                                <span class="text-muted">Periode:</span>
                                                                <strong><?= esc($t['periode_bulan']); ?></strong>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-muted">Total Transfer:</span>
                                                                <strong class="text-primary fs-5">Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?></strong>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Upload Resi / Bukti Transfer</label>
                                                            <input type="file" class="form-control" name="bukti_bayar" accept="image/png, image/jpeg, image/jpg" required>
                                                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0 pb-4 px-4">
                                                        <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-teal text-white rounded-pill px-4 fw-bold">Kirim Bukti Pembayaran</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Belum ada data tagihan yang tercatat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>