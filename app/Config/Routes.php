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
