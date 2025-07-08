<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'lapangan_id',
        'booking_date',
        'start_time',
        'end_time',
        'total_price',
        'payment_status',
        'booking_status',
        'payment_proof',
        'admin_notes'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi
    protected $validationRules = [
        'user_id'        => 'required|integer',
        'lapangan_id'        => 'required|integer',
        'booking_date'   => 'required|valid_date',
        'start_time'     => 'required',
        'end_time'       => 'required',
        'total_price'    => 'required|numeric|greater_than[0]',
        'payment_status' => 'in_list[Menunggu Konfirmasi,Sudah Dibayar,Disetujui,Ditolak]',
        'booking_status' => 'in_list[Menunggu Konfirmasi,Disetujui,Ditolak, Selesai, Dibatalkan]',
        'payment_proof'  => 'permit_empty|max_length[255]',
        'admin_notes'    => 'permit_empty|max_length[500]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    public function getBookingDetails($id = null, $userId = null)
    {
        $builder = $this->db->table('bookings');
        $builder->select('bookings.*, users.username, users.email, users.no_hp, lapangan.name AS lapangan_name, lapangan.price_per_hour');
        $builder->join('users', 'users.id = bookings.user_id');
        $builder->join('lapangan', 'lapangan.id = bookings.lapangan_id');

        if ($id !== null) {
            $builder->where('bookings.id', $id);
        }

        if ($userId !== null) {
            $builder->where('bookings.user_id', $userId);
        }

        return ($id !== null) ? $builder->get()->getRowArray() : $builder->get()->getResultArray();
    }



    public function isLapanganAvailable(int $lapanganId, string $bookingDate, string $startTime, string $endTime, ?int $excludeBookingId = null): bool
    {
        $query = $this->where('lapangan_id', $lapanganId)
            ->where('booking_date', $bookingDate)
            ->where('booking_status !=', 'Dibatalkan')
            ->groupStart()
            ->where('start_time <', $endTime)
            ->where('end_time >', $startTime)
            ->groupEnd();

        if ($excludeBookingId) {
            $query->where('id !=', $excludeBookingId);
        }

        return $query->countAllResults() === 0;
    }
}
