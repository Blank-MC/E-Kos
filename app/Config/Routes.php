<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =================================================================
// RUTE PUBLIK (GUEST)
// =================================================================
$routes->get('/', 'Home::index');
$routes->get('kamar', 'Home::kamar');
$routes->get('kamar/detail/(:num)', 'Home::detail/$1');
$routes->get('pesan/(:num)', 'Home::pesan/$1');
$routes->post('pesan/store', 'Home::storePesan');

// =================================================================
// RUTE AUTENTIKASI (LOGIN & LOGOUT)
// =================================================================
$routes->get('login', 'Auth::login');
$routes->post('auth/proses', 'Auth::proses_login');
$routes->get('logout', 'Auth::logout');


// =================================================================
// RUTE PENGHUNI (WAJIB LOGIN)
// =================================================================
$routes->group('penghuni', ['namespace' => 'App\Controllers\Penghuni'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    // Tagihan & Pembayaran
    $routes->get('tagihan', 'Tagihan::index');
    $routes->post('tagihan/bayar', 'Tagihan::bayar');

    // Profil Saya
    $routes->get('profil', 'Profil::index');
    $routes->post('profil/update', 'Profil::update');

    // Pusat Pengaduan / Keluhan
    $routes->get('pengaduan', 'Pengaduan::index');
    $routes->post('pengaduan/store', 'Pengaduan::store');
});


// =================================================================
// RUTE ADMIN (WAJIB LOGIN ADMIN)
// =================================================================
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
        $routes->get('delete/(:num)', 'Kamar::delete/$1');
        $routes->delete('delete/(:num)', 'Kamar::delete/$1');
    });

    // Rute Fasilitas
    $routes->group('fasilitas', function ($routes) {
        $routes->get('/', 'Fasilitas::index');
        $routes->post('store', 'Fasilitas::store');
        $routes->post('update/(:num)', 'Fasilitas::update/$1');
        $routes->get('delete/(:num)', 'Fasilitas::delete/$1');
    });

    // Rute Penghuni
    $routes->group('penghuni', function ($routes) {
        $routes->get('/', 'Penghuni::index');
        $routes->post('updateAkun/(:num)', 'Penghuni::updateAkun/$1');
        $routes->get('delete/(:num)', 'Penghuni::delete/$1');
        $routes->delete('delete/(:num)', 'Penghuni::delete/$1');
    });

    // Rute Sewa
    $routes->group('sewa', function ($routes) {
        $routes->get('/', 'Sewa::index');
        $routes->get('status/(:num)/(:alpha)', 'Sewa::updateStatus/$1/$2');
    });

    // Rute Transaksi / Tagihan
    $routes->group('transaksi', function ($routes) {
        $routes->get('/', 'Transaksi::index');
        $routes->get('konfirmasi/(:num)', 'Transaksi::konfirmasi/$1');
    });

    // Rute Pengaduan Penghuni (Admin)
    $routes->group('pengaduan', function ($routes) {
        $routes->get('/', 'Pengaduan::index');
        $routes->post('update/(:num)', 'Pengaduan::update/$1');
        $routes->get('delete/(:num)', 'Pengaduan::delete/$1');
    });

    // Rute Laporan
    $routes->group('laporan', function ($routes) {
        $routes->get('/', 'Laporan::index');
        $routes->get('excel', 'Laporan::exportExcel');
        $routes->get('pdf', 'Laporan::exportPdf');
    });

    // Rute Pengaturan
    $routes->group('pengaturan', function ($routes) {
        $routes->get('/', 'Pengaturan::index');
        $routes->post('update/(:num)', 'Pengaturan::update/$1');
    });
});
