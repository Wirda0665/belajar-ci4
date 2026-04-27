<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
    <div class='col-lg-8'>
        <div class='card shadow-sm'>
            <div class='card-header bg-primary text-white'>
                <h4 class='mb-0'><i class='bi bi-person-circle'></i> Profil Mahasiswa</h4>
            </div>
            <div class='card-body'>
                <div class='row mb-4 align-items-center'>
                    <div class='col-md-3 text-center mb-3 mb-md-0'>
                        <img src='<?= esc(avatar_url($nama)) ?>'
                            alt='Avatar <?= esc($nama) ?>'
                            class='rounded-circle img-fluid border'
                            style='max-width: 160px;'>
                    </div>
                    <div class='col-md-9'>
                        <div class='d-flex align-items-center gap-2 mb-2'>
                            <span class='badge bg-secondary fs-6'><?= esc(inisial_nama($nama)) ?></span>
                            <h5 class='mb-0'><?= esc($nama) ?></h5>
                        </div>
                    </div>
                </div>
                <div class='row mb-3'>
                    <div class='col-sm-6'>
                        <h6 class='text-muted'>NPM</h6>
                        <p class='fs-6'><?= esc($npm) ?></p>
                    </div>
                    <div class='col-sm-6'>
                        <h6 class='text-muted'>Program Studi</h6>
                        <p class='fs-6'><?= esc($prodi) ?></p>
                    </div>
                </div>
                <div class='row mb-3'>
                    <div class='col-sm-6'>
                        <h6 class='text-muted'>Fakultas</h6>
                        <p class='fs-6'><?= esc($fakultas) ?></p>
                    </div>
                    <div class='col-sm-6'>
                        <h6 class='text-muted'>Angkatan</h6>
                        <p class='fs-6'><?= esc($angkatan) ?></p>
                    </div>
                </div>
                <div class='row mb-4'>
                    <div class='col-sm-6'>
                        <h6 class='text-muted'>IPK</h6>
                        <p class='fs-6'>
                            <span class='badge bg-<?= esc($ipk_badge) ?>'><?= esc(number_format($ipk, 2)) ?></span>
                        </p>
                    </div>
                </div>
                <h6 class='text-muted'>Mata Kuliah yang Sedang Diambil</h6>
                <ul class='list-group'>
                    <?php foreach ($mata_kuliah as $matkul): ?>
                        <li class='list-group-item'><?= esc($matkul) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>