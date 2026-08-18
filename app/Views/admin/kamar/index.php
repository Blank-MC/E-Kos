<?= $this->extend('layout/admin_template') ?>

<?= $this->section('sidebar_menu') ?>
<li class="nav-item"><a href="<?= base_url('admin') ?>" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a></li>
<li class="nav-item"><a href="<?= base_url('admin/kamar') ?>" class="nav-link active"><i class="nav-icon fas fa-door-open"></i>
        <p>Kelola Kamar</p>
    </a></li>
<li class="nav-item"><a href="#" class="nav-link text-muted"><i class="nav-icon fas fa-tags"></i>
        <p>Data Fasilitas</p>
    </a></li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card card-primary card-outline shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title fw-bold m-0">Daftar Kamar</h3>
        <a href="<?= base_url('admin/kamar/create') ?>" class="btn btn-primary btn-sm ml-auto"><i class="fas fa-plus"></i> Tambah</a>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle text-nowrap">
            <thead class="bg-light">
                <tr>
                    <th>Foto</th>
                    <th>Nama Kamar</th>
                    <th>Tipe</th>
                    <th>Harga/Bulan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kamar as $k) : ?>
                    <tr>
                        <td>
                            <?php if ($k['foto_utama']) : ?>
                                <img src="<?= base_url('uploads/kamar/' . $k['foto_utama']) ?>" class="img-thumbnail" style="height: 50px;">
                            <?php else : ?>
                                <div class="bg-secondary text-white text-center rounded" style="width:50px;height:50px;line-height:50px;"><i class="fas fa-image"></i></div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold"><?= esc($k['nama_kamar']); ?></td>
                        <td><?= esc($k['tipe']); ?></td>
                        <td class="text-primary fw-bold">Rp <?= number_format($k['harga_bulanan'], 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($k['status'] == 'kosong') : ?><span class="badge badge-success">Kosong</span>
                            <?php elseif ($k['status'] == 'terisi') : ?><span class="badge badge-danger">Terisi</span>
                            <?php else : ?><span class="badge badge-warning text-dark">Maintenance</span><?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/kamar/edit/' . $k['id']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="<?= base_url('admin/kamar/delete/' . $k['id']) ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kamar?');"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>