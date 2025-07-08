<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\LapanganModel;
use Dompdf\Dompdf;

class Reports extends BaseController
{
    protected $bookingModel;
    protected $lapanganModel;
    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->lapanganModel = new LapanganModel();
    }
    public function index()
    {

        $lapanganUsageData = $this->bookingModel
            ->select('lapangan.name as lapangan_name, COUNT(bookings.id) as total_bookings')
            ->join('lapangan', 'lapangan.id = bookings.lapangan_id')
            ->groupBy('lapangan.name')
            ->findAll();

        $lapanganNames = [];
        $bookingCounts = [];
        foreach ($lapanganUsageData as $data) {
            $lapanganNames[] = $data['lapangan_name'];
            $bookingCounts[] = $data['total_bookings'];
        }


        $allBookings = $this->bookingModel->getBookingDetails();

        $data = [
            'title'         => 'Laporan & Grafik',
            'lapangan_names'   => json_encode($lapanganNames), // Untuk Chart.js 
            'booking_counts' => json_encode($bookingCounts), // Untuk Chart.js
            'all_bookings'  => $allBookings,
        ];
        return view('admin/reports/index', $data);
    }

    public function download()
    {
        $bookingModel = new \App\Models\BookingModel();
        $bookings = $bookingModel->getBookingDetails();

        $data = [
            'title' => 'Laporan Semua Booking',
            'bookings' => $bookings,
        ];

        $html = view('admin/reports/laporan_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-booking-' . date('YmdHis') . '.pdf', ['Attachment' => true]);
    }
}
