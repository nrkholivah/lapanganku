<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class Bookings extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Manajemen Booking',
            'bookings' => $this->bookingModel->getBookingDetails(),
        ];
        return view('admin/bookings/index', $data);
    }

    public function detail($id = null)
    {
        $booking = $this->bookingModel->getBookingDetails($id);

        if (! $booking) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booking tidak ditemukan: ' . $id);
        }

        $data = [
            'title'   => 'Detail Booking: #' . $booking['id'],
            'booking' => $booking,
        ];
        return view('admin/bookings/detail', $data);
    }

    public function approvePayment($bookingId = null)
    {
        $booking = $this->bookingModel->find($bookingId);

        if (! $booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan.');
        }

        $data = [
            'payment_status' => 'Disetujui',
            'booking_status' => 'Disetujui',
            'admin_notes'    => $this->request->getPost('admin_notes'),
        ];

        if ($this->bookingModel->update($bookingId, $data)) {
            return redirect()->to(base_url('admin/bookings/detail/' . $bookingId))->with('success', 'Pembayaran berhasil disetujui dan booking dikonfirmasi.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyetujui pembayaran.');
        }
    }

    public function rejectPayment($bookingId = null)
    {
        $booking = $this->bookingModel->find($bookingId);

        if (! $booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan.');
        }

        $data = [
            'payment_status' => 'Ditolak',
            'booking_status' => 'Dibatalkan',
            'admin_notes'    => $this->request->getPost('admin_notes'),
        ];

        if ($this->bookingModel->update($bookingId, $data)) {
            return redirect()->to(base_url('admin/bookings/detail/' . $bookingId))->with('success', 'Pembayaran ditolak dan booking dibatalkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menolak pembayaran.');
        }
    }

    public function cancelBooking($bookingId = null)
    {
        $booking = $this->bookingModel->find($bookingId);

        if (! $booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan.');
        }

        $data = [
            'booking_status' => 'Dibatalkan',
            'admin_notes'    => $this->request->getPost('admin_notes'),
        ];

        if ($this->bookingModel->update($bookingId, $data)) {
            return redirect()->to(base_url('admin/bookings/detail/' . $bookingId))->with('success', 'Booking berhasil dibatalkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal membatalkan booking.');
        }
    }
}
