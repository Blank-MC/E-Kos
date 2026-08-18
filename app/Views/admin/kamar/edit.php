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
<div class="card card-warning card-outline shadow-sm">
    <div class="card-header">
        <h3 class="card-title fw-bold">Edit Kamar, Fasilitas, & Galeri</h3>
    </div>
    <form action="<?= base_url('admin/kamar/update/' . $kamar['id']) ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="card-body row">
            <div class="col-md-6 form-group"><label>Nama Kamar</label><input type="text" class="form-control" name="nama_kamar" value="<?= esc($kamar['nama_kamar']); ?>" required></div>
            <div class="col-md-6 form-group"><label>Tipe Kamar</label><input type="text" class="form-control" name="tipe" value="<?= esc($kamar['tipe']); ?>" required></div>
            <div class="col-md-6 form-group"><label>Harga Bulanan</label><input type="number" class="form-control" name="harga_bulanan" value="<?= esc($kamar['harga_bulanan']); ?>" required></div>
            <div class="col-md-6 form-group"><label>Ukuran</label><input type="text" class="form-control" name="ukuran" value="<?= esc($kamar['ukuran']); ?>"></div>

            <!-- Checkbox Fasilitas -->
            <div class="col-md-12 form-group">
                <label class="fw-bold">Fasilitas Kamar</label>
                <div class="row border rounded p-3 bg-light">
                    <?php foreach ($fasilitas as $f) : ?>
                        <div class="col-md-3 form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="fasilitas[]" value="<?= $f['id']; ?>" id="fasilitas<?= $f['id']; ?>" <?= in_array($f['id'], $idFasilitasAktif) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="fasilitas<?= $f['id']; ?>">
                                <?php if ($f['icon']): ?><i class="<?= esc($f['icon']); ?> mr-1 text-primary"></i><?php endif; ?>
                                <?= esc($f['nama_fasilitas']); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-12 form-group"><label>Deskripsi</label><textarea class="form-control" name="deskripsi" rows="3"><?= esc($kamar['deskripsi']); ?></textarea></div>

            <div class="col-md-6 form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="kosong" <?= $kamar['status'] == 'kosong' ? 'selected' : ''; ?>>Kosong</option>
                    <option value="terisi" <?= $kamar['status'] == 'terisi' ? 'selected' : ''; ?>>Terisi</option>
                    <option value="maintenance" <?= $kamar['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label>Ganti Foto Utama (Kosongkan jika tetap)</label>
                <input type="file" class="form-control-file" name="foto_utama" accept="image/*">
            </div>

            <!-- Kelola Galeri Foto -->
            <div class="col-md-12 form-group mt-3 border-top pt-3">
                <label class="fw-bold">Galeri Foto Tambahan</label>
                <input type="file" class="form-control-file mb-3" name="galeri_foto[]" multiple accept="image/*">

                <div class="row">
                    <?php foreach ($galeriList as $g) : ?>
                        <div class="col-md-3 text-center position-relative mb-3">
                            <img src="<?= base_url('uploads/kamar/galeri/' . $g['file_foto']) ?>" class="img-thumbnail shadow-sm" style="height: 100px; width: 100%; object-fit: cover;">
                            <br>
                            <a href="<?= base_url('admin/kamar/deleteFoto/' . $g['id'] . '/' . $kamar['id']) ?>" class="btn btn-danger btn-xs mt-1" onclick="return confirm('Hapus foto galeri ini?');">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($galeriList)) : ?>
                        <div class="col-12 text-muted small">Belum ada foto galeri tambahan untuk kamar ini.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="<?= base_url('admin/kamar') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-warning fw-bold">Update Data</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>