<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class='row justify-content-center'>
    <div class='col-md-6'>
        <div class='card shadow'>
            <div class='card-header bg-primary text-white py-3'>
                <h4 class='mb-0'><i class='bi bi-key'></i> Ganti Password</h4>
            </div>
            <div class='card-body p-4'>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class='alert alert-danger'>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <?php $errors = session()->getFlashdata('errors') ?? []; ?>
                <?php if (!empty($errors)): ?>
                    <div class='alert alert-danger'>
                        <ul class='mb-0 ps-3'>
                            <?php foreach ($errors as $e): ?>
                                <li><?= esc($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action='<?= base_url('akun/proses-ganti-password') ?>' method='post'>
                    <?= csrf_field() ?>
                    
                    <div class='mb-3'>
                        <label class='form-label fw-bold'>Password Lama *</label>
                        <input type='password' name='password_lama' class='form-control' required>
                    </div>

                    <div class='mb-3'>
                        <label class='form-label fw-bold'>Password Baru *</label>
                        <input type='password' name='password_baru' class='form-control'
                            placeholder='Min. 8 karakter' required>
                    </div>

                    <div class='mb-4'>
                        <label class='form-label fw-bold'>Konfirmasi Password Baru *</label>
                        <input type='password' name='konfirmasi' class='form-control' required>
                    </div>

                    <button type='submit' class='btn btn-primary w-100'>
                        <i class='bi bi-save'></i> Simpan Password Baru
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
