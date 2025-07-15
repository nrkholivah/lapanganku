<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\LapanganModel; 
class Home extends BaseController
{
    protected $lapanganModel; 

    public function __construct()
    {
        $this->lapanganModel = new LapanganModel(); 
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title'  => 'Daftar Lapangan',
            'lapangans' => $this->lapanganModel->findAll(), 
        ];
        return view('user/home', $data);
    }

    public function detail($id = null)
    {
        $lapangan = $this->lapanganModel->find($id); 

        if (! $lapangan) { 
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lapangan tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Detail Lapangan: ' . $lapangan['name'], 
            'lapangan' => $lapangan, 
        ];
        return view('user/lapangan_detail', $data); 
    }
}
