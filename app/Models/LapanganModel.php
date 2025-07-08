<?php

namespace App\Models;

use CodeIgniter\Model;

class LapanganModel extends Model
{
    protected $table            = 'lapangan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'price_per_hour', 'image', 'status'];


    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi
    protected $validationRules = [
        'name'           => 'required|min_length[3]|max_length[100]',
        'description'    => 'permit_empty|max_length[500]',
        'price_per_hour' => 'required|numeric|greater_than[0]',
        'image'          => 'permit_empty|max_length[255]',
        'status'         => 'in_list[Tersedia,Perawatan,Penuh]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;
}
