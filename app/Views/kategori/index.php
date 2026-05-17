<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='d-flex justify-content-between align-items-center mb-4'>
    <div>
        <h2><i class='bi bi-tags'></i> Daftar Kategori</h2>
        <p class='text-muted mb-0'>Total: <?= $total ?> kategori ditemukan</p>
    </div>
    <a href='<?= base_url('kategori/tambah') ?>' class='btn btn-primary'>
        <i class='bi bi-plus-circle'></i> Tambah Kategori
    </a>
</div>

<!-- Form Pencarian -->
<form method='GET' action='<?= base_url('kategori') ?>' class='mb-4'>
    <div class='input-group'>
        <input type='text' name='q' class='form-control'
            placeholder='Cari nama kategori...'
            value='<?= esc($keyword) ?>'>
        <button class='btn btn-outline-secondary' type='submit'>
            <i class='bi bi-search'></i> Cari
        </button>
        <?php if ($keyword): ?>
            <a href='<?= base_url('kategori') ?>' class='btn btn-outline-danger'>
                <i class='bi bi-x'></i> Reset
            </a>
        <?php endif; ?>
    </div>
</form>

<!-- Tabel Kategori -->
<?php if (empty($kategori)): ?>
    <div class='text-center py-5'>
        <i class='bi bi-inbox display-1 text-muted'></i>
        <h4 class='mt-3 text-muted'>Tidak ada kategori ditemukan</h4>
        <?php if ($keyword): ?>
            <p>Coba kata kunci lain atau <a href='<?= base_url('kategori') ?>'>lihat semua kategori</a>.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class='table-responsive'>
        <table class='table table-hover table-bordered align-middle'>
            <thead class='table-primary'>
                <tr>
                    <th width='60'>No.</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th width='120'>Jumlah Buku</th>
                    <th width='130'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori as $i => $k): ?>
                    <tr>
                        <td class='text-center'><?= ($pager->getCurrentPage() - 1) * 10 + $i + 1 ?></td>
                        <td><strong><?= esc($k['nama']) ?></strong></td>
                        <td><?= esc($k['deskripsi'] ?? '-') ?></td>
                        <td class='text-center'>
                            <span class='badge bg-<?= $k['jumlah_buku'] > 0 ? 'success' : 'secondary' ?>'>
                                <?= $k['jumlah_buku'] ?> Buku
                            </span>
                        </td>
                        <td class='text-center'>
                            <a href='<?= base_url('kategori/edit/' . $k['id']) ?>' class='btn btn-sm btn-warning' title='Edit'>
                                <i class='bi bi-pencil'></i>
                            </a>
                            <a href='<?= base_url('kategori/hapus/' . $k['id']) ?>'
                                class='btn btn-sm btn-danger'
                                title='Hapus'
                                onclick="return confirm('Yakin ingin menghapus kategori \'<?= esc($k['nama'], 'js') ?>\'?')">
                                <i class='bi bi-trash'></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class='d-flex justify-content-center mt-3'>
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
