<?= $this->extend('layout/admin_template') ?>

<?= $this->section('sidebar_menu') ?>
<!-- Sidebar Menu -->
<li class="nav-item"><a href="<?= base_url('admin') ?>" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/kamar') ?>" class="nav-link"><i class="nav-icon fas fa-door-open"></i>
        <p>Kelola Kamar</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/fasilitas') ?>" class="nav-link active"><i class="nav-icon fas fa-tags"></i>
        <p>Data Fasilitas</p>
    </a></li>
<li class="nav-item"><a href="#" class="nav-link text-muted"><i class="nav-icon fas fa-users"></i>
        <p>Data Penghuni</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success shadow-sm"><i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('pesan'); ?></div>
        <?php endif; ?>
    </div>

    <!-- Kolom Kiri: Form Tambah -->
    <div class="col-md-4">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">Tambah Fasilitas</h3>
            </div>
            <form action="<?= base_url('admin/fasilitas/store') ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label>Nama Fasilitas</label>
                        <input type="text" class="form-control" name="nama_fasilitas" placeholder="Contoh: WiFi, AC..." required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Icon FontAwesome</label>
                        <input type="text" class="form-control" name="icon" placeholder="Contoh: fas fa-wifi">
                        <small class="text-muted">Opsional. Cari icon di fontawesome.com</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block fw-bold"><i class="fas fa-save mr-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Tabel Data -->
    <div class="col-md-8">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">Daftar Master Fasilitas</h3>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" width="10%">No</th>
                            <th class="text-center" width="15%">Icon</th>
                            <th>Nama Fasilitas</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($fasilitas as $f) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="text-center">
                                    <?php if ($f['icon']) : ?><i class="<?= esc($f['icon']); ?> text-primary fa-lg"></i><?php else : ?>-<?php endif; ?>
                                </td>
                                <td class="fw-bold"><?= esc($f['nama_fasilitas']); ?></td>
                                <td class="text-center">
                                    <!-- Tombol Edit (Membuka Modal) -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $f['id']; ?>"><i class="fas fa-edit"></i></button>

                                    <!-- Form Delete -->
                                    <form action="<?= base_url('admin/fasilitas/delete/' . $f['id']) ?>" method="POST" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus fasilitas <?= $f['nama_fasilitas']; ?>?');"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Spesifik untuk setiap baris -->
                            <div class="modal fade" id="editModal<?= $f['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title fw-bold">Edit Fasilitas</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form action="<?= base_url('admin/fasilitas/update/' . $f['id']) ?>" method="POST">
                                            <?= csrf_field(); ?>
                                            <div class="modal-body text-left">
                                                <div class="form-group mb-3">
                                                    <label>Nama Fasilitas</label>
                                                    <input type="text" class="form-control" name="nama_fasilitas" value="<?= esc($f['nama_fasilitas']); ?>" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label>Icon</label>
                                                    <input type="text" class="form-control" name="icon" value="<?= esc($f['icon']); ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning fw-bold">Update Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>