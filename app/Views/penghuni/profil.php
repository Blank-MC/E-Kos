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
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold m-0 text-dark"><i class="fas fa-user-circle text-primary me-2"></i>Biodata & Pengaturan Akun</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('penghuni/profil/update'); ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="foto_profil_lama" value="<?= esc($profil['foto_profil'] ?? ''); ?>">
                    <input type="hidden" name="foto_ktp_lama" value="<?= esc($profil['foto_ktp'] ?? ''); ?>">

                    <div class="row g-4">
                        <!-- Foto Profil Preview -->
                        <div class="col-lg-3 text-center">
                            <div class="mb-3">
                                <img src="<?= !empty($profil['foto_profil']) ? base_url('uploads/profil/' . $profil['foto_profil']) : 'https://via.placeholder.com/150?text=Foto+Profil'; ?>" class="rounded-circle img-thumbnail shadow-sm" style="width: 140px; height: 140px; object-fit: cover;" alt="Foto Profil">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Ganti Foto Profil</label>
                                <input type="file" class="form-control form-control-sm" name="foto_profil" accept="image/*">
                            </div>
                        </div>

                        <!-- Data Isian Form -->
                        <div class="col-lg-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" value="<?= esc($profil['nama'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email Login</label>
                                    <input type="email" class="form-control bg-light" value="<?= esc($profil['email'] ?? ''); ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No. WhatsApp / HP</label>
                                    <input type="text" class="form-control" name="no_hp" value="<?= esc($profil['no_hp'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jenis Kelamin</label>
                                    <select class="form-select" name="jenis_kelamin">
                                        <option value="L" <?= (($profil['jenis_kelamin'] ?? '') == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="P" <?= (($profil['jenis_kelamin'] ?? '') == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">NIK (KTP)</label>
                                    <input type="text" class="form-control" name="nik" value="<?= esc($profil['nik'] ?? ''); ?>" placeholder="Nomor Induk Kependudukan">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Pekerjaan</label>
                                    <input type="text" class="form-control" name="pekerjaan" value="<?= esc($profil['pekerjaan'] ?? ''); ?>" placeholder="Mahasiswa / Karyawan">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Kontak Darurat (Ortu / Saudara)</label>
                                    <input type="text" class="form-control" name="kontak_darurat" value="<?= esc($profil['kontak_darurat'] ?? ''); ?>" placeholder="Nomor kontak darurat">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Upload Foto KTP</label>
                                    <input type="file" class="form-control" name="foto_ktp" accept="image/*">
                                    <?php if (!empty($profil['foto_ktp'])) : ?>
                                        <small class="text-success"><i class="fas fa-check-circle me-1"></i> File KTP tersimpan</small>
                                    <?php endif; ?>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Asal</label>
                                    <textarea class="form-control" name="alamat_asal" rows="3" placeholder="Alamat asal sesuai KTP..."><?= esc($profil['alamat_asal'] ?? ''); ?></textarea>
                                </div>

                                <!-- Bagian Ganti Password -->
                                <div class="col-12 mt-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-key text-warning me-2"></i>Ganti Kata Sandi (Opsional)</h6>
                                        <p class="text-muted small mb-3">Kosongkan kolom di bawah jika tidak ingin mengganti password akun.</p>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Password Saat Ini</label>
                                                <input type="password" class="form-control" name="password_lama" placeholder="Masukkan password lama">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small fw-bold">Password Baru</label>
                                                <input type="password" class="form-control" name="password_baru" placeholder="Minimal 6 karakter">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-teal text-white fw-bold px-4 py-2 rounded-3">
                                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>