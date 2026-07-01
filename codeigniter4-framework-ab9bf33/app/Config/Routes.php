<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ============================================================
// ROUTE PUBLIK (tanpa filter)
// ============================================================
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

// Smart redirect — arahkan ke dashboard sesuai role
$routes->get('/dashboard', 'Dashboard::index');

// ============================================================
// ROUTE ADMIN (filter: admin — harus login + role admin)
// ============================================================
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard', 'AdminDashboard::index');

    // CRUD User
    $routes->get('users', 'Admin::users');
    $routes->post('users/save', 'Admin::saveUser');
    $routes->get('users/edit/(:num)', 'Admin::users/$1');
    $routes->get('users/delete/(:num)', 'Admin::deleteUser/$1');

    // CRUD Modul
    $routes->get('modul', 'Admin::modules');
    $routes->post('modul/save', 'Admin::saveModule');
    $routes->get('modul/edit/(:num)', 'Admin::modules/$1');
    $routes->get('modul/delete/(:num)', 'Admin::deleteModule/$1');

    // CRUD Soal Kuis
    $routes->get('soal', 'Admin::soal');
    $routes->post('soal/save', 'Admin::saveSoal');
    $routes->get('soal/edit/(:num)', 'Admin::soal/$1');
    $routes->get('soal/delete/(:num)', 'Admin::deleteSoal/$1');

    // CRUD Progress Karyawan
    $routes->get('progress', 'Admin::progress');
    $routes->post('progress/save', 'Admin::saveProgress');
    $routes->get('progress/edit/(:num)', 'Admin::progress/$1');
    $routes->get('progress/delete/(:num)', 'Admin::deleteProgress/$1');

    // CRUD Sertifikat
    $routes->get('sertifikat-manage', 'Admin::sertifikatAdmin');
    $routes->post('sertifikat-manage/save', 'Admin::saveSertifikat');
    $routes->get('sertifikat-manage/edit/(:num)', 'Admin::sertifikatAdmin/$1');
    $routes->get('sertifikat-manage/delete/(:num)', 'Admin::deleteSertifikat/$1');

    // Halaman data (lihat semua karyawan)
    $routes->get('kuis', 'Pages::kuis');
    $routes->get('kuis/export', 'Pages::exportKuis');
    $routes->get('sertifikat', 'Pages::sertifikat');
    $routes->get('sertifikat/export', 'Pages::exportSertifikat');
    $routes->get('about', 'Pages::about');
});

// ============================================================
// ROUTE KARYAWAN (filter: karyawan — harus login + role karyawan)
// ============================================================
$routes->group('karyawan', ['filter' => 'karyawan'], static function ($routes) {
    $routes->get('dashboard', 'KaryawanDashboard::index');

    // Halaman data (lihat data sendiri saja)
    $routes->get('modul', 'KaryawanPages::modul');
    $routes->get('modul/materi/(:num)', 'KaryawanPages::materi/$1');
    $routes->get('kuis', 'KaryawanPages::kuis');
    $routes->get('sertifikat', 'KaryawanPages::sertifikat');
    $routes->get('about', 'KaryawanPages::about');

    // Isi kuis
    $routes->get('kuis/mulai/(:num)', 'KaryawanPages::isiKuis/$1');
    $routes->post('kuis/submit/(:num)', 'KaryawanPages::submitKuis/$1');
    $routes->get('kuis/hasil/(:num)', 'KaryawanPages::hasilKuis/$1');

    // Print sertifikat
    $routes->get('sertifikat/print/(:num)', 'KaryawanPages::printSertifikat/$1');
});

// ============================================================
// ROUTE LAMA — redirect ke route baru agar tidak broken
// ============================================================
$routes->get('/modul', 'Dashboard::index');
$routes->get('/kuis', 'Dashboard::index');
$routes->get('/sertifikat', 'Dashboard::index');
$routes->get('/users', 'Dashboard::index');
$routes->get('/about', 'Dashboard::index');

// ============================================================
// REST API (tidak terpengaruh perubahan role)
// ============================================================
$routes->group('api', static function ($routes) {
	$routes->get('users', 'Api\Users::index');
	$routes->get('users/(:num)', 'Api\Users::show/$1');
	$routes->post('users', 'Api\Users::create');
	$routes->put('users/(:num)', 'Api\Users::update/$1');
	$routes->delete('users/(:num)', 'Api\Users::delete/$1');

	$routes->get('modules', 'Api\Modules::index');
	$routes->get('modules/(:num)', 'Api\Modules::show/$1');
	$routes->post('modules', 'Api\Modules::create');
	$routes->put('modules/(:num)', 'Api\Modules::update/$1');
	$routes->delete('modules/(:num)', 'Api\Modules::delete/$1');
});