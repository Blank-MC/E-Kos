<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');
$routes->get('kamar', 'Home::kamar');
$routes->get('kamar/detail/(:num)', 'Home::detail/$1');
$routes->get('pesan/(:num)', 'Home::pesan/$1');
$routes->post('pesan/store', 'Home::storePesan');
$routes->get('login', 'Auth::login');


// Grouping Route khusus halaman Admin
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Rute utama ketika mengakses /admin
    $routes->get('/', 'Dashboard::index');

    // Rute Kamar
    $routes->group('kamar', function ($routes) {
        $routes->get('/', 'Kamar::index');
        $routes->get('create', 'Kamar::create');
        $routes->post('store', 'Kamar::store');
        $routes->get('edit/(:num)', 'Kamar::edit/$1');
        $routes->post('update/(:num)', 'Kamar::update/$1');
        $routes->delete('delete/(:num)', 'Kamar::delete/$1');
    });

    // Rute Fasilitas
    $routes->group('fasilitas', function ($routes) {
        $routes->get('/', 'Fasilitas::index');
        $routes->post('store', 'Fasilitas::store');
        $routes->post('update/(:num)', 'Fasilitas::update/$1');
        $routes->delete('delete/(:num)', 'Fasilitas::delete/$1');
    });

    // Rute Penghuni
    $routes->group('penghuni', function ($routes) {
        $routes->get('/', 'Penghuni::index');
        $routes->delete('delete/(:num)', 'Penghuni::delete/$1');
    });

    // Rute Sewa
    $routes->group('sewa', function ($routes) {
        $routes->get('/', 'Sewa::index');
        $routes->get('status/(:num)/(:alpha)', 'Sewa::updateStatus/$1/$2');
    });

    // Rute Transaksi
    $routes->group('transaksi', function ($routes) {
        $routes->get('/', 'Transaksi::index');
        $routes->get('konfirmasi/(:num)', 'Transaksi::konfirmasi/$1');
    });

    // Rute Laporan
    $routes->get('laporan', 'Laporan::index');

    // Rute Pengaturan
    $routes->group('pengaturan', function ($routes) {
        $routes->get('/', 'Pengaturan::index');
        $routes->post('update/(:num)', 'Pengaturan::update/$1');
    });
});
