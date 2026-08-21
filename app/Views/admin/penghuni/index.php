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
                <h3 class="card-title fw-bold m-0">Daftar Penghuni Kos</h3>
            </div>

            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 60px;">No</th>
                            <th>Nama Lengkap</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th>Kontak & Akun</th>
                            <th class="text-center">Status Akun</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($penghuni as $p) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="fw-bold">
                                    <?= esc($p['nama']); ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($p['jenis_kelamin'] == 'L') : ?>
                                        <span class="badge badge-info"><i class="fas fa-mars mr-1"></i> Laki-laki</span>
                                    <?php elseif ($p['jenis_kelamin'] == 'P') : ?>
                                        <span class="badge badge-danger"><i class="fas fa-venus mr-1"></i> Perempuan</span>
                                    <?php else : ?>
                                        <span class="badge badge-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div><i class="fab fa-whatsapp text-success mr-1"></i> <?= esc($p['no_hp'] ?: '-'); ?></div>
                                    <small class="text-muted"><i class="fas fa-envelope mr-1"></i> <?= esc($p['email']); ?></small>
                                </td>
                                <td class="text-center">
                                    <?php if ($p['status'] == 'aktif') : ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge badge-warning text-dark">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Pemicu Modal Edit -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $p['id_user'] ?? $p['id']; ?>">
                                        <i class="fas fa-key"></i> Edit Akun
                                    </button>

                                    <!-- Form Hapus -->
                                    <form action="<?= base_url('admin/penghuni/delete/' . $p['id']) ?>" method="POST" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus penghuni ini? Data akun dan sewanya akan ikut terhapus!');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Akun & Password -->
                            <div class="modal fade" id="editModal<?= $p['id_user'] ?? $p['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-user-edit mr-2"></i>Edit Akun: <?= esc($p['nama']); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('admin/penghuni/updateAkun/' . ($p['id_user'] ?? $p['id'])) ?>" method="POST">
                                            <?= csrf_field(); ?>
                                            <div class="modal-body text-left">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Email Login</label>
                                                    <input type="email" class="form-control" name="email" value="<?= esc($p['email']); ?>" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">No. WhatsApp</label>
                                                    <input type="text" class="form-control" name="no_hp" value="<?= esc($p['no_hp']); ?>" required>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Status Akun</label>
                                                    <select class="form-control" name="status">
                                                        <option value="aktif" <?= $p['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                                                        <option value="nonaktif" <?= $p['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                                                    </select>
                                                </div>
                                                <hr>
                                                <div class="form-group mb-2">
                                                    <label class="font-weight-bold text-danger"><i class="fas fa-lock mr-1"></i>Reset Password Baru</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Kosongkan jika password tidak diubah">
                                                    <small class="form-text text-muted">Isi kolom ini jika penghuni lupa password atau ingin reset password baru.</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-sm font-weight-bold">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                        <?php if (empty($penghuni)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data penghuni yang terdaftar.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>