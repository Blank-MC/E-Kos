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
<li class="nav-item"><a href="<?= base_url('admin/penghuni') ?>" class="nav-link active"><i class="nav-icon fas fa-users"></i>
        <p>Data Penghuni</p>
    </a></li>
<li class="nav-item"><a href="#" class="nav-link text-muted"><i class="nav-icon fas fa-clipboard-check"></i>
        <p>Pengajuan Sewa</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success shadow-sm"><i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('pesan'); ?></div>
        <?php endif; ?>

        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title fw-bold m-0">Daftar Penghuni Kos</h3>
                <!-- Fitur tambah penghuni manual bisa dikembangkan nanti -->
                <button class="btn btn-primary btn-sm ml-auto disabled"><i class="fas fa-plus"></i> Tambah Manual</button>
            </div>

            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Lengkap</th>
                            <th>Kontak</th>
                            <th>Asal & Pekerjaan</th>
                            <th class="text-center">Dokumen KTP</th>
                            <th class="text-center">Status Akun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($penghuni as $p) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="fw-bold">
                                    <?= esc($p['nama']); ?><br>
                                    <small class="text-muted">NIK: <?= esc($p['nik'] ?: '-'); ?></small>
                                </td>
                                <td>
                                    <i class="fas fa-phone-alt text-success mr-1"></i> <?= esc($p['no_hp'] ?: '-'); ?><br>
                                    <small class="text-muted"><i class="fas fa-envelope mr-1"></i> <?= esc($p['email']); ?></small>
                                </td>
                                <td>
                                    <?= esc($p['alamat_asal'] ?: '-'); ?><br>
                                    <small class="text-muted">Kerja: <?= esc($p['pekerjaan'] ?: '-'); ?></small>
                                </td>
                                <td class="text-center">
                                    <?php if ($p['foto_ktp']) : ?>
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#ktpModal<?= $p['id']; ?>"><i class="fas fa-id-card"></i> Lihat</button>
                                    <?php else : ?>
                                        <span class="badge badge-secondary">Belum Upload</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($p['status'] == 'aktif') : ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <form action="<?= base_url('admin/penghuni/delete/' . $p['id']) ?>" method="POST" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus penghuni ini? Akun login juga akan terhapus!');"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Lihat KTP -->
                            <?php if ($p['foto_ktp']) : ?>
                                <div class="modal fade" id="ktpModal<?= $p['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title fw-bold">KTP - <?= esc($p['nama']); ?></h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="<?= base_url('uploads/ktp/' . $p['foto_ktp']) ?>" class="img-fluid rounded shadow-sm" alt="Foto KTP">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>

                        <?php if (empty($penghuni)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data penghuni.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>