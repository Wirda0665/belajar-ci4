<!DOCTYPE html>
<html lang='id'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?= isset($title) ? esc($title) . ' - MyApp' : 'MyApp' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Bootstrap Icons -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css' rel='stylesheet'>
    <!-- Custom CSS -->
    <link rel='stylesheet' href='<?= base_url('assets/css/custom.css') ?>'>
</head>

<body>
    <!-- NAVBAR -->
    <nav class='navbar navbar-expand-lg navbar-dark bg-primary shadow-sm'>
        <div class='container'>
            <a class='navbar-brand' href='<?= base_url('/') ?>'>
                <i class='bi bi-book'></i> PerpustakaanKu
            </a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navMenu'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navMenu'>
                <ul class='navbar-nav me-auto'>
                    <li class='nav-item'>
                        <!-- url_is('/') mendeteksi halaman beranda/root -->
                        <a class='nav-link <?= url_is('/') ? 'active' : '' ?>' href='<?= base_url('/') ?>'>
                            <i class='bi bi-house'></i> Beranda
                        </a>
                    </li>
                    <li class='nav-item'>
                        <!-- Menggunakan wildcard * agar menu tetap aktif di sub-halaman (misal: buku/detail/1) -->
                        <a class='nav-link <?= url_is('buku*') ? 'active' : '' ?>' href='<?= base_url('buku') ?>'>
                            <i class='bi bi-journals'></i> Buku
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link <?= url_is('kategori*') ? 'active' : '' ?>' href='<?= base_url('kategori') ?>'>
                            <i class='bi bi-tags'></i> Kategori
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link <?= url_is('tentang*') ? 'active' : '' ?>' href='<?= base_url('tentang') ?>'>
                            <i class='bi bi-info-circle'></i> Tentang
                        </a>
                    </li>
                </ul>
                <div class='navbar-nav'>
                    <?php if (session()->get('logged_in')): ?>
                        <span class='navbar-text me-3 text-light'>
                            <i class='bi bi-person-circle'></i> <?= esc(session()->get('nama')) ?>
                        </span>
                        <a class='btn btn-outline-light btn-sm' href='<?= base_url('logout') ?>'>
                            <i class='bi bi-box-arrow-right'></i> Logout
                        </a>
                    <?php else: ?>
                        <a class='btn btn-outline-light btn-sm' href='<?= base_url('login') ?>'>
                            <i class='bi bi-box-arrow-in-right'></i> Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <!-- BREADCRUMB -->
    <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
        <div class='bg-white border-bottom py-2'>
            <div class='container'>
                <nav aria-label='breadcrumb'>
                    <ol class='breadcrumb mb-0'>
                        <li class='breadcrumb-item'>
                            <a href='<?= base_url('/') ?>'>Beranda</a>
                        </li>
                        <?php 
                        $totalItems = count($breadcrumb);
                        $counter = 0;
                        foreach ($breadcrumb as $crumb): 
                            $counter++;
                            // Jika ini adalah elemen terakhir, set menjadi active text (bukan link)
                            if ($counter === $totalItems): 
                        ?>
                            <li class='breadcrumb-item active' aria-current='page'>
                                <?= esc($crumb['label']) ?>
                            </li>
                        <?php else: ?>
                            <li class='breadcrumb-item'>
                                <a href='<?= esc($crumb['url']) ?>'><?= esc($crumb['label']) ?></a>
                            </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </div>
        </div>
    <?php endif; ?>
    <!-- END BREADCRUMB -->

    <!-- KONTEN UTAMA -->
    <main class='container py-4'>
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('sukses')): ?>
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <i class='bi bi-check-circle-fill me-2'></i>
                <?= esc(session()->getFlashdata('sukses')) ?>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='bi bi-exclamation-triangle-fill me-2'></i>
                <?= esc(session()->getFlashdata('error')) ?>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('info')): ?>
            <div class='alert alert-info alert-dismissible fade show' role='alert'>
                <i class='bi bi-info-circle-fill me-2'></i>
                <?= esc(session()->getFlashdata('info')) ?>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>
        <?php endif; ?>

        <!-- SECTION KONTEN HALAMAN -->
        <?= $this->renderSection('content') ?>
    </main>
    <!-- END KONTEN UTAMA -->

    <!-- FOOTER -->
    <footer class='py-4 mt-5 bg-dark text-light'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-6'>
                    <h5><i class='bi bi-book'></i> PerpustakaanKu</h5>
                    <p class='text-muted mb-0'>Sistem Informasi Perpustakaan Digital</p>
                </div>
                <div class='col-md-6 text-md-end'>
                    <p class='text-muted mb-1'>Dibangun dengan CodeIgniter 4</p>
                    <p class='text-muted mb-0'>&copy; <?= date('Y') ?> Praktikum Pemrograman Web 2</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- END FOOTER -->

    <!-- Bootstrap 5 JS Bundle (Termasuk Popper) -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>