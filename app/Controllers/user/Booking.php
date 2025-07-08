<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LapanganModel; 

class Booking extends BaseController
{
    protected $bookingModel;
    protected $lapanganModel; 

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->lapanganModel = new LapanganModel(); 
        helper(['form', 'url', 'filesystem']);
    }

    public function create()
    {
        $rules = [
            'lapangan_id'    => 'required|integer', 
            'booking_date' => 'required|valid_date',
            'start_time'   => 'required',
            'end_time'     => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $lapanganId = $this->request->getPost('lapangan_id'); 
        $bookingDate = $this->request->getPost('booking_date');
        $startTime = $this->request->getPost('start_time');
        $endTime = $this->request->getPost('end_time');

        $lapangan = $this->lapanganModel->find($lapanganId); 
        if (! $lapangan) { 
            return redirect()->back()->with('error', 'Lapangan tidak ditemukan.');
        }

        // Cek ketersediaan lapangan
        if (! $this->bookingModel->isLapanganAvailable($lapanganId, $bookingDate, $startTime, $endTime)) { 
            return redirect()->back()->withInput()->with('error', 'Lapangan tidak tersedia pada jam tersebut.');
        }

        // Hitung total harga
        $start = strtotime($startTime);
        $end = strtotime($endTime);
        $durationHours = ($end - $start) / 3600;
        $totalPrice = $durationHours * $lapangan['price_per_hour'];

        $data = [
            'user_id'      => session()->get('user_id'),
            'lapangan_id'      => $lapanganId,
            'booking_date' => $bookingDate,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            'total_price'  => $totalPrice,
            'payment_status' => 'Menunggu Konfirmasi',
            'booking_status' => 'Menunggu Konfirmasi',
        ];

        if ($this->bookingModel->insert($data)) {
            return redirect()->to(base_url('my-bookings'))->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat booking.');
        }
    }

    public function myBookings()
    {
        $userId = session()->get('user_id');
        $bookings = $this->bookingModel->where('user_id', $userId)->getBookingDetails();

        $data = [
            'title'    => 'Booking Saya',
            'bookings' => $bookings,
        ];
        return view('user/my_bookings', $data);
    }

    public function uploadPaymentProof($bookingId = null)
    {
        $booking = $this->bookingModel->find($bookingId);

        if (! $booking || $booking['user_id'] !== session()->get('user_id')) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $rules = [
            'payment_proof' => 'uploaded[payment_proof]|max_size[payment_proof,2048]|is_image[payment_proof]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('payment_proof');
        if ($file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/payments', $newName);

            $data = [
                'payment_proof'  => 'uploads/payments/' . $newName,
                'payment_status' => 'Sudah Dibayar',
            ];

            if ($this->bookingModel->update($bookingId, $data)) {
                return redirect()->to(base_url('my-bookings'))->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
            }
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah file.');
    }
}
