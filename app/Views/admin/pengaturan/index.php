<?= $this->extend('layout/admin_template') ?>
<?= $this->section('sidebar_menu') ?>
<li class="nav-item"><a href="<?= base_url('admin/pengaturan') ?>" class="nav-link active"><i class="nav-icon fas fa-cog"></i>
        <p>Pengaturan Kos</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success shadow-sm"><i class="fas fa-check-circle mr-2"></i> <?= session()->getFlashdata('pesan'); ?></div>
        <?php endif; ?>
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title fw-bold">Profil & Identitas Kos</h3>
            </div>
            <form action="<?= base_url('admin/pengaturan/update/' . $pengaturan['id']) ?>" method="POST">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group mb-3"><label>Nama Kos</label><input type="text" class="form-control" name="nama_kos" value="<?= esc($pengaturan['nama_kos']); ?>" required></div>
                    <div class="form-group mb-3"><label>No Telp / WhatsApp</label><input type="text" class="form-control" name="no_telp" value="<?= esc($pengaturan['no_telp']); ?>"></div>
                    <div class="form-group mb-3"><label>Email</label><input type="email" class="form-control" name="email" value="<?= esc($pengaturan['email']); ?>"></div>
                    <div class="form-group mb-3"><label>Alamat Lengkap</label><textarea class="form-control" name="alamat" rows="2"><?= esc($pengaturan['alamat']); ?></textarea></div>
                    <div class="form-group mb-3"><label>Deskripsi Kos</label><textarea class="form-control" name="deskripsi" rows="3"><?= esc($pengaturan['deskripsi']); ?></textarea></div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>