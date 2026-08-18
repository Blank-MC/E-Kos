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

<!-- Custom CSS untuk Kotak Galeri Icon -->
<style>
    .icon-picker-grid {
        max-height: 160px;
        overflow-y: auto;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 8px;
        background: #f8f9fa;
    }

    .icon-option-btn {
        width: 38px;
        height: 38px;
        padding: 0;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 2px;
    }
</style>

<?php
// Daftar icon yang lebih lengkap untuk berbagai kategori fasilitas
$array_icon = [
    // Umum & Properti
    'fas fa-home',
    'fas fa-building',
    'fas fa-hotel',
    'fas fa-warehouse',
    'fas fa-city',
    'fas fa-door-open',
    'fas fa-door-closed',
    'fas fa-key',
    'fas fa-lock',
    'fas fa-shield-alt',

    // Perabotan & Kamar
    'fas fa-bed',
    'fas fa-couch',
    'fas fa-chair',
    'fas fa-table',
    'fas fa-tv',
    'fas fa-desktop',
    'fas fa-lightbulb',
    'fas fa-plug',
    'fas fa-charging-station',

    // Fasilitas Kebersihan & Dapur
    'fas fa-wifi',
    'fas fa-snowflake',
    'fas fa-bath',
    'fas fa-shower',
    'fas fa-hot-tub',
    'fas fa-utensils',
    'fas fa-water',
    'fas fa-tshirt',
    'fas fa-broom',
    'fas fa-trash',
    'fas fa-soap',
    'fas fa-sink',
    'fas fa-fan',
    'fas fa-fire-extinguisher',

    // Kendaraan & Area Luar
    'fas fa-car',
    'fas fa-motorcycle',
    'fas fa-parking',
    'fas fa-bicycle',
    'fas fa-road',
    'fas fa-swimming-pool',
    'fas fa-dumbbell',
    'fas fa-tree',
    'fas fa-umbrella-beach',

    // Keamanan & Utilitas Tambahan
    'fas fa-video',
    'fas fa-camera',
    'fas fa-bolt',
    'fas fa-wifi',
    'fas fa-signal',
    'fas fa-hammer',
    'fas fa-paint-roller',
    'fas fa-toolbox',
    'fas fa-box',
    'fas fa-calendar-alt',
    'fas fa-clock',
    'fas fa-user-shield',
    'fas fa-concierge-bell'
];
?>

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
                        <input type="text" class="form-control mb-2" name="icon" id="input-icon-tambah" placeholder="Pilih icon dari kotak di bawah">
                        <small class="text-muted">Pilih icon dari galeri di bawah:</small>

                        <!-- Kotak Grid Banyak Icon (Bisa Di-scroll) -->
                        <div class="icon-picker-grid mt-1">
                            <?php foreach ($array_icon as $ic): ?>
                                <button type="button" class="btn btn-outline-secondary icon-option-btn select-icon-tambah" data-icon="<?= $ic; ?>" title="<?= $ic; ?>">
                                    <i class="<?= $ic; ?>"></i>
                                </button>
                            <?php endforeach; ?>
                        </div>
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
                                                    <input type="text" class="form-control mb-2" name="icon" id="input-icon-edit-<?= $f['id']; ?>" value="<?= esc($f['icon']); ?>">
                                                    <small class="text-muted">Pilih icon dari galeri di bawah:</small>

                                                    <!-- Kotak Grid Banyak Icon untuk Edit -->
                                                    <div class="icon-picker-grid mt-1">
                                                        <?php foreach ($array_icon as $ic): ?>
                                                            <button type="button" class="btn btn-outline-secondary icon-option-btn select-icon-edit" data-id="<?= $f['id']; ?>" data-icon="<?= $ic; ?>" title="<?= $ic; ?>">
                                                                <i class="<?= $ic; ?>"></i>
                                                            </button>
                                                        <?php endforeach; ?>
                                                    </div>
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

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '.select-icon-tambah', function() {
            let iconClass = $(this).data('icon');
            $('#input-icon-tambah').val(iconClass);
            $(this).parent().find('.icon-option-btn').removeClass('btn-primary').addClass('btn-outline-secondary');
            $(this).removeClass('btn-outline-secondary').addClass('btn-primary');
        });

        $(document).on('click', '.select-icon-edit', function() {
            let id = $(this).data('id');
            let iconClass = $(this).data('icon');
            $('#input-icon-edit-' + id).val(iconClass);
            $(this).parent().find('.icon-option-btn').removeClass('btn-primary').addClass('btn-outline-secondary');
            $(this).removeClass('btn-outline-secondary').addClass('btn-primary');
        });
    });
</script>
<?= $this->endSection() ?>