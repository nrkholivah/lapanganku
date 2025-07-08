<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('User\Home'); // Controller default untuk user
$routes->setDefaultMethod('index');
$routes->setAutoRoute(true);
$routes->get('/', 'User\Home::index', ['filter' => 'auth']); // Halaman utama, butuh login
$routes->get('/lapangan/(:num)', 'User\Home::detail/$1', ['filter' => 'auth']); // Detail lapangan
$routes->post('/booking/create', 'User\Booking::create', ['filter' => 'auth']); // Proses booking
$routes->get('/my-bookings', 'User\Booking::myBookings', ['filter' => 'auth']); // Booking saya
$routes->post('/booking/upload-payment/(:num)', 'User\Booking::uploadPaymentProof/$1', ['filter' => 'auth']); // Upload bukti bayar

// Rute Otentikasi
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');

// Rute Admin 
$routes->group(
    'admin',
    ['filter' => 'adminAuth'],
    function ($routes) {
        $routes->get('/', 'Admin\Dashboard::index'); // Dashboard Admin

        // CRUD Lapangan
        $routes->get('lapangan', 'Admin\Lapangan::index');
        $routes->get('lapangan/create', 'Admin\Lapangan::create');
        $routes->post('lapangan/store', 'Admin\Lapangan::store');
        $routes->get('lapangan/edit/(:num)', 'Admin\Lapangan::edit/$1');
        $routes->post('lapangan/update/(:num)', 'Admin\Lapangan::update/$1');
        $routes->get('lapangan/delete/(:num)', 'Admin\Lapangan::delete/$1');

        // CRUD Booking & Persetujuan Pembayaran
        $routes->get('bookings', 'Admin\Bookings::index');
        $routes->get('bookings/detail/(:num)', 'Admin\Bookings::detail/$1');
        $routes->post('bookings/approve-payment/(:num)', 'Admin\Bookings::approvePayment/$1');
        $routes->post('bookings/reject-payment/(:num)', 'Admin\Bookings::rejectPayment/$1');
        $routes->post('bookings/cancel-booking/(:num)', 'Admin\Bookings::cancelBooking/$1');

        // Laporan & Grafik
        $routes->get('reports', 'Admin\Reports::index');
        $routes->get('reports/download', 'Admin\Reports::download');
    }
);
