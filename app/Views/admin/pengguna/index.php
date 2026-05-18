<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h2><i class="bi bi-people"></i> Manajemen Pengguna</h2>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($pengguna as $u) : ?>
                        <?php $isCurrentUser = ($u['id'] == session()->get('user_id')); ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($u['nama_lengkap']) ?></td>
                            <td><?= esc($u['username']) ?></td>
                            <td><?= esc($u['email']) ?></td>
                            <td>
                                <?php if ($isCurrentUser) : ?>
                                    <span class="badge bg-secondary w-100 py-2"><?= esc(ucfirst($u['role'])) ?></span>
                                <?php else : ?>
                                    <form action="<?= base_url('admin/pengguna/ubah-role/' . $u['id']) ?>" method="post" class="m-0">
                                        <?= csrf_field() ?>
                                        <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="anggota" <?= $u['role'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
                                            <option value="petugas" <?= $u['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                            <option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($u['aktif'] == 1) : ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else : ?>
                                    <span class="badge bg-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($isCurrentUser) : ?>
                                    <button class="btn btn-sm btn-secondary" disabled title="Tidak dapat mengubah akun sendiri">
                                        <i class="bi bi-shield-lock"></i> Akun Anda
                                    </button>
                                <?php else : ?>
                                    <form action="<?= base_url('admin/pengguna/toggle-aktif/' . $u['id']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <?php if ($u['aktif'] == 1) : ?>
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Yakin ingin menonaktifkan pengguna ini?')">
                                                <i class="bi bi-person-x"></i> Nonaktifkan
                                            </button>
                                        <?php else : ?>
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin mengaktifkan pengguna ini?')">
                                                <i class="bi bi-person-check"></i> Aktifkan
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($pengguna)): ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pengguna.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
