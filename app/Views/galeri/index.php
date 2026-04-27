<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class='mb-4'>
    <div class='d-flex flex-column flex-md-row justify-content-between align-items-start gap-3'>
        <div>
            <h1 class='mb-1'>Galeri</h1>
            <p class='text-muted mb-0'>Jelajahi koleksi gambar berdasarkan kategori.</p>
        </div>
        <?php if (!empty($kategori_terpilih)): ?>
            <div class='text-muted small'>Filter aktif: <strong><?= esc(ucfirst($kategori_terpilih)) ?></strong></div>
        <?php endif; ?>
    </div>
</div>
<div class='mb-4'>
    <div class='btn-group flex-wrap' role='group' aria-label='Filter kategori'>
        <a href='<?= base_url('galeri') ?>'
            class='btn btn-sm <?= empty($kategori_terpilih) ? 'btn-primary' : 'btn-outline-primary' ?>'>Semua</a>
        <?php foreach ($kategori_list as $kategori): ?>
            <a href='<?= base_url('galeri') . '?kategori=' . urlencode($kategori) ?>'
                class='btn btn-sm <?= strtolower($kategori_terpilih) === strtolower($kategori) ? 'btn-primary' : 'btn-outline-primary' ?>'>
                <?= esc(ucfirst($kategori)) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php if (empty($galeri)): ?>
    <div class='alert alert-warning'>
        Tidak ada gambar untuk kategori "<?= esc($kategori_terpilih) ?>".
    </div>
<?php else: ?>
    <div class='row gy-4'>
        <?php foreach ($galeri as $item): ?>
            <div class='col-md-4'>
                <div class='card h-100 shadow-sm'>
                    <div class='ratio ratio-4x3 overflow-hidden'>
                        <img src='<?= esc($item['url_gambar']) ?>' class='object-fit-cover w-100 h-100' alt='<?= esc($item['judul']) ?>'>
                    </div>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title mb-2'><?= esc($item['judul']) ?></h5>
                        <p class='mb-2'>
                            <span class='badge bg-secondary'><?= esc(ucfirst($item['kategori'])) ?></span>
                        </p>
                        <p class='card-text text-muted'><?= esc(truncate_text($item['deskripsi'], 120)) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>