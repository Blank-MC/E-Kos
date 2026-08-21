<?= $this->extend('layout/admin_template') ?>

<?= $this->section('sidebar_menu') ?>
<!-- Sidebar Menu -->
<li class="nav-item"><a href="<?= base_url('admin') ?>" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/kamar') ?>" class="nav-link"><i class="nav-icon fas fa-door-open"></i>
        <p>Kelola Kamar</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/fasilitas') ?>" class="nav-link"><i class="nav-icon fas fa-tags"></i>
        <p>Data Fasilitas</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/sewa') ?>" class="nav-link active"><i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Pengajuan Sewa</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/penghuni') ?>" class="nav-link text-muted"><i class="nav-icon fas fa-users"></i>
        <p>Data Penghuni</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">

        <!-- Notifikasi -->
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success shadow-sm"><i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('pesan'); ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger shadow-sm"><i class="fas fa-exclamation-circle mr-2"></i> <?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header border-0 pb-0">
                <h3 class="card-title fw-bold"><i class="fas fa-clipboard-list text-primary mr-2"></i> Kelola Pengajuan Sewa</h3>
            </div>
            <div class="card-body p-0 mt-3 table-responsive">
                <table class="table table-hover table-striped align-middle text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Calon Penghuni</th>
                            <th>Kamar</th>
                            <th>Tgl Masuk</th>
                            <th>Durasi</th>
                            <th>Total Tagihan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sewa)) : ?>
                            <?php $i = 1;
                            foreach ($sewa as $s) : ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td class="font-weight-bold text-primary"><?= esc($s['nama_penghuni']); ?></td>
                                    <td><span class="badge badge-info"><i class="fas fa-door-closed mr-1"></i> <?= esc($s['nama_kamar']); ?></span></td>
                                    <td><?= date('d M Y', strtotime($s['tanggal_masuk'])); ?></td>
                                    <td><?= esc($s['durasi_sewa']); ?> Bulan</td>
                                    <td class="font-weight-bold text-success">Rp <?= number_format($s['total_tagihan'], 0, ',', '.'); ?></td>

                                    <td class="text-center">
                                        <?php if ($s['status'] == 'Pending') : ?>
                                            <span class="badge badge-warning text-dark"><i class="fas fa-clock mr-1"></i> Menunggu Konfirmasi</span>
                                        <?php elseif ($s['status'] == 'Berjalan') : ?>
                                            <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Aktif</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger"><i class="fas fa-times-circle mr-1"></i> Ditolak</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <!-- Tombol Lihat Bukti Transfer -->
                                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalBukti<?= $s['id']; ?>" title="Lihat Bukti Transfer">
                                            <i class="fas fa-image"></i> Cek Bukti
                                        </button>

                                        <!-- Tombol Aksi Jika Status Masih Pending -->
                                        <?php if ($s['status'] == 'Pending') : ?>
                                            <a href="<?= base_url('admin/sewa/status/' . $s['id'] . '/approve') ?>" class="btn btn-sm btn-success" onclick="return confirm('Setujui pengajuan ini? Kamar akan otomatis menjadi penuh.');" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="<?= base_url('admin/sewa/status/' . $s['id'] . '/reject') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tolak pengajuan ini?');" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Modal Lihat Bukti Transfer (Muncul saat tombol Cek Bukti diklik) -->
                                <div class="modal fade" id="modalBukti<?= $s['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-receipt mr-2"></i> Bukti Transfer - <?= esc($s['nama_penghuni']); ?></h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center bg-light p-4">
                                                <?php if ($s['bukti_bayar']) : ?>
                                                    <img src="<?= base_url('uploads/bukti/' . $s['bukti_bayar']); ?>" class="img-fluid rounded shadow-sm" alt="Bukti Transfer" style="max-height: 500px; width: 100%; object-fit: contain;">
                                                    <p class="mt-3 font-weight-bold text-success mb-0">Total yang harus dibayar: Rp <?= number_format($s['total_tagihan'], 0, ',', '.'); ?></p>
                                                <?php else : ?>
                                                    <div class="py-5 text-muted">
                                                        <i class="fas fa-image fa-3x mb-3 opacity-50"></i>
                                                        <p>Tidak ada foto bukti transfer.</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0">
                                                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal -->

                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i><br>
                                    <span class="font-weight-bold">Belum ada data pengajuan sewa.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>