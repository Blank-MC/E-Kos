<?= $this->extend('layout/admin_template') ?>

<?= $this->section('sidebar_menu') ?>
<li class="nav-item"><a href="<?= base_url('admin') ?>" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/kamar') ?>" class="nav-link active"><i class="nav-icon fas fa-door-open"></i>
        <p>Kelola Kamar</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline shadow-sm">
    <div class="card-header">
        <h3 class="card-title fw-bold">Tambah Kamar, Fasilitas, & Galeri</h3>
    </div>
    <form action="<?= base_url('admin/kamar/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="card-body row">
            <div class="col-md-6 form-group"><label>Nama Kamar</label><input type="text" class="form-control" name="nama_kamar" required></div>
            <div class="col-md-6 form-group"><label>Tipe Kamar (Misal: VIP)</label><input type="text" class="form-control" name="tipe" required></div>
            <div class="col-md-6 form-group"><label>Harga Bulanan</label><input type="number" class="form-control" name="harga_bulanan" required></div>
            <div class="col-md-6 form-group"><label>Ukuran (Misal: 3x4 m)</label><input type="text" class="form-control" name="ukuran"></div>

            <!-- Checkbox Fasilitas -->
            <div class="col-md-12 form-group">
                <label class="fw-bold">Fasilitas Kamar</label>
                <div class="row border rounded p-3 bg-light">
                    <?php foreach ($fasilitas as $f) : ?>
                        <div class="col-md-3 form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="<?= $f['id']; ?>" id="fasilitas<?= $f['id']; ?>">
                            <label class="form-check-label" for="fasilitas<?= $f['id']; ?>">
                                <?php if ($f['icon']): ?><i class="<?= esc($f['icon']); ?> mr-1 text-primary"></i><?php endif; ?>
                                <?= esc($f['nama_fasilitas']); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-12 form-group"><label>Deskripsi</label><textarea class="form-control" name="deskripsi" rows="3"></textarea></div>

            <div class="col-md-6 form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="kosong">Kosong</option>
                    <option value="terisi">Terisi</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label>Foto Utama</label>
                <input type="file" class="form-control-file" name="foto_utama" accept="image/*">
            </div>

            <!-- Multi-Upload Galeri -->
            <div class="col-md-12 form-group mt-3">
                <label class="fw-bold">Galeri Foto Tambahan (Bisa pilih banyak sekaligus)</label>
                <input type="file" class="form-control-file" name="galeri_foto[]" multiple accept="image/*">
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="<?= base_url('admin/kamar') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary fw-bold">Simpan Kamar</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>