<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Route default (halaman beranda)
$routes->get('/', 'Beranda::index');
// Route halaman tentang
$routes->get('tentang', 'Beranda::tentang');

// Route untuk Controller Akademik
$routes->get('akademik', 'Akademik::index');

$routes->get('akademik/matkul', 'Akademik::matkul');

$routes->get('akademik/nilai/(:any)', 'Akademik::nilai/$1');

// Route halaman Profil
$routes->get('profil', 'Profil::index');

// Route controller Demo
$routes->get('demo', 'Demo::index');

// Route halaman Galeri
$routes->get('galeri', 'Galeri::index');

// Route CRUD Buku
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');

// Route CRUD Kategori
$routes->get('kategori', 'Kategori::index');
$routes->get('kategori/tambah', 'Kategori::tambah');
$routes->post('kategori/simpan', 'Kategori::simpan');
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/hapus/(:num)', 'Kategori::hapus/$1');

// ═══════════════════════════════════════════
// AUTH ROUTES — tidak butuh login
// ═══════════════════════════════════════════
$routes->get('login', 'Auth::login');
$routes->post('login/proses', 'Auth::prosesLogin');
$routes->get('register', 'Auth::register');
$routes->post('register/proses', 'Auth::prosesRegister');
$routes->get('logout', 'Auth::logout');
// ═══════════════════════════════════════════
// ROUTES YANG MEMBUTUHKAN LOGIN
// ═══════════════════════════════════════════
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Buku - READ boleh semua yang sudah login
    $routes->get('buku', 'Buku::index');
    $routes->get('buku/detail/(:num)', 'Buku::detail/$1');
    $routes->get('buku/statistik', 'Buku::statistik');
    // Buku - WRITE hanya admin dan petugas
    $routes->group('buku', ['filter' => 'role'], function ($routes) {
        $routes->get('tambah', 'Buku::tambah');
        $routes->post('simpan', 'Buku::simpan');
        $routes->get('edit/(:num)', 'Buku::edit/$1');
        $routes->post('update/(:num)', 'Buku::update/$1');
        $routes->get('hapus/(:num)', 'Buku::hapus/$1');
        $routes->get('ekspor', 'Buku::ekspor');
    });
    // Kategori - hanya admin dan petugas
    $routes->group('kategori', ['filter' => 'role'], function ($routes) {
        $routes->get('/', 'Kategori::index');
        $routes->get('tambah', 'Kategori::tambah');
        $routes->post('simpan', 'Kategori::simpan');
        $routes->get('edit/(:num)', 'Kategori::edit/$1');
        $routes->post('update/(:num)', 'Kategori::update/$1');
        $routes->get('hapus/(:num)', 'Kategori::hapus/$1');
    });
    // Area admin - hanya role admin
    $routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
        $routes->get('/', 'Admin\Dashboard::index');
        $routes->get('pengguna', 'Admin\Pengguna::index');
        $routes->post('pengguna/toggle-aktif/(:num)', 'Admin\Pengguna::toggleAktif/$1');
        $routes->post('pengguna/ubah-role/(:num)', 'Admin\Pengguna::ubahRole/$1');
    });
    // Akun - untuk pengguna yang sudah login
    $routes->group('akun', function ($routes) {
        $routes->get('ganti-password', 'Akun::gantiPassword');
        $routes->post('proses-ganti-password', 'Akun::prosesGantiPassword');
    });
});
