<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-bar-chart-line text-primary"></i> Statistik Koleksi Buku</h2>
        <p class="text-muted mb-0">Informasi ringkas mengenai persediaan dan distribusi buku.</p>
    </div>
    <div>
        <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Buku
        </a>
    </div>
</div>

<!-- Ringkasan Statistik -->
<div class="row g-4 mb-4">
    <!-- Card Total Buku -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-white-50 text-uppercase mb-2">Total Buku</h6>
                    <h2 class="display-5 fw-bold mb-0"><?= number_format($statistik['total_buku']) ?></h2>
                    <p class="text-white-50 mb-0 mt-2">Judul Buku Terdaftar</p>
                </div>
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="bi bi-journal-text display-4"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Total Stok -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-white-50 text-uppercase mb-2">Total Stok</h6>
                    <h2 class="display-5 fw-bold mb-0"><?= number_format($statistik['total_stok']) ?></h2>
                    <p class="text-white-50 mb-0 mt-2">Eksemplar Buku Fisik</p>
                </div>
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="bi bi-boxes display-4"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Card Rata-rata Stok -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-white-50 text-uppercase mb-2">Rata-rata Stok</h6>
                    <h2 class="display-5 fw-bold mb-0"><?= number_format($statistik['rata_stok'], 2) ?></h2>
                    <p class="text-white-50 mb-0 mt-2">Eksemplar per Judul</p>
                </div>
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="bi bi-calculator display-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Tabel Distribusi per Kategori -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0"><i class="bi bi-tags-fill text-info"></i> Distribusi Buku per Kategori</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($statistik['distribusi_kategori'])): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-tag text-muted display-1"></i>
                        <p class="text-muted mt-3">Tidak ada data kategori ditemukan.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60" class="ps-4 text-center">No.</th>
                                    <th>Kategori</th>
                                    <th width="150" class="text-center">Jumlah Judul</th>
                                    <th width="150" class="text-center">Jumlah Stok</th>
                                    <th width="180" class="pe-4 text-center">Persentase Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach ($statistik['distribusi_kategori'] as $dist): 
                                    // Hitung persentase terhadap total stok
                                    $persen = $statistik['total_stok'] > 0 ? ($dist['jumlah_stok'] / $statistik['total_stok']) * 100 : 0;
                                ?>
                                    <tr>
                                        <td class="ps-4 text-center text-muted"><?= $no++ ?></td>
                                        <td>
                                            <strong><?= esc($dist['nama_kategori'] ?? 'Tanpa Kategori') ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary rounded-pill"><?= number_format($dist['jumlah_buku']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-dark rounded-pill"><?= number_format($dist['jumlah_stok']) ?></span>
                                        </td>
                                        <td class="pe-4">
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar bg-info rounded" role="progressbar" 
                                                         style="width: <?= $persen ?>%;" 
                                                         aria-valuenow="<?= $persen ?>" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100"></div>
                                                </div>
                                                <span class="ms-2 small text-muted"><?= round($persen, 1) ?>%</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Stok Terbanyak & Restock -->
    <div class="col-lg-5 d-flex flex-column gap-4">
        <!-- 5 Buku dengan Stok Terbanyak -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0"><i class="bi bi-trophy-fill text-warning"></i> 5 Buku dengan Stok Terbanyak</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($statistik['stok_terbanyak'])): ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Tidak ada data buku ditemukan.</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($statistik['stok_terbanyak'] as $b): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div style="max-width: 80%;">
                                    <h6 class="mb-1 text-truncate"><?= esc($b['judul']) ?></h6>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-person"></i> <?= esc($b['penulis']) ?>
                                    </small>
                                    <span class="badge bg-light text-dark border mt-1">
                                        <i class="bi bi-tag"></i> <?= esc($b['nama_kategori'] ?? 'Tanpa Kategori') ?>
                                    </span>
                                </div>
                                <span class="badge bg-success fs-6 rounded-pill">
                                    <?= $b['stok'] ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Buku Stok Kosong (Restock) -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0"><i class="bi bi-exclamation-octagon-fill text-danger"></i> Buku Perlu Restock (Stok 0)</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($statistik['stok_kosong'])): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle-fill text-success display-4 mb-2 d-block"></i>
                        <h6 class="text-success mb-1">Semua Buku Tersedia!</h6>
                        <p class="text-muted small px-3 mb-0">Tidak ada buku yang memiliki stok kosong saat ini.</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
                        <?php foreach ($statistik['stok_kosong'] as $b): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3 border-danger-subtle bg-danger-subtle bg-opacity-10">
                                <div style="max-width: 80%;">
                                    <h6 class="mb-1 text-danger text-truncate" style="max-width: 250px;"><?= esc($b['judul']) ?></h6>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-person"></i> <?= esc($b['penulis']) ?> | Kode: <code><?= esc($b['kode_buku']) ?></code>
                                    </small>
                                </div>
                                <a href="<?= base_url('buku/edit/' . $b['id']) ?>" class="btn btn-sm btn-outline-danger" title="Edit Stok">
                                    Restock
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
