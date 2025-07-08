<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LapanganModel; 
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $bookingModel;
    protected $lapanganModel; 
    protected $userModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->lapanganModel = new LapanganModel(); 
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'             => 'Dashboard Admin',
            'total_users'       => $this->userModel->countAllResults(),
            'total_lapangan'    => $this->lapanganModel->countAllResults(), 
            'total_bookings'    => $this->bookingModel->countAllResults(),
            'pending_payments'  => $this->bookingModel->where('payment_status', 'paid')->countAllResults(),
            'recent_bookings'   => $this->bookingModel->orderBy('created_at', 'DESC')->limit(5)->getBookingDetails(),
        ];
        return view('admin/dashboard', $data);
    }
}
