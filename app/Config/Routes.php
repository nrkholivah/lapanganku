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

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');
