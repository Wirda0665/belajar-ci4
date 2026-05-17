<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php $isEdit = !is_null($kategori); ?>

<div class='row justify-content-center'>
    <div class='col-md-8'>
        <div class='card shadow-sm'>
            <div class='card-header bg-primary text-white'>
                <h4 class='mb-0'>
                    <i class='bi bi-<?= $isEdit ? 'pencil' : 'plus-circle' ?>'></i>
                    <?= esc($title) ?>
                </h4>
            </div>
            <div class='card-body'>
                <!-- Error dari session -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class='alert alert-danger'>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <form action='<?= base_url($isEdit ? 'kategori/update/' . $kategori['id'] : 'kategori/simpan') ?>' method='post'>
                    <?= csrf_field() ?>
                    
                    <div class='mb-3'>
                        <label class='form-label fw-bold'>Nama Kategori <span class='text-danger'>*</span></label>
                        <input type='text' name='nama' class='form-control'
                            value='<?= esc(old('nama', $kategori['nama'] ?? '')) ?>' required>
                    </div>

                    <div class='mb-3'>
                        <label class='form-label fw-bold'>Deskripsi</label>
                        <textarea name='deskripsi' rows='4' class='form-control'><?= esc(old('deskripsi', $kategori['deskripsi'] ?? '')) ?></textarea>
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <div class='d-flex gap-2 mt-4'>
                        <button type='submit' class='btn btn-primary'>
                            <i class='bi bi-save'></i> <?= $isEdit ? 'Perbarui' : 'Simpan' ?>
                        </button>
                        <a href='<?= base_url('kategori') ?>' class='btn btn-secondary'>
                            <i class='bi bi-x-circle'></i> Batal
                        </a>
                        
                        <?php if ($isEdit): ?>
                            <a href='<?= base_url('kategori/hapus/' . $kategori['id']) ?>'
                                class='btn btn-danger ms-auto'
                                onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                <i class='bi bi-trash'></i> Hapus Kategori
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
