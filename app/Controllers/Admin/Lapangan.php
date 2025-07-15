<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LapanganModel;

class Lapangan extends BaseController
{
    protected $lapanganModel;
    public function __construct()
    {
        $this->lapanganModel = new LapanganModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Lapangan',
            'lapangan' => $this->lapanganModel->findAll(), 
        ];
        return view('admin/lapangan/index', $data); 
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Lapangan Baru',
        ];
        return view('admin/lapangan/form', $data); 
    }

    public function store()
    {
        $rules = [
            'name'           => 'required|min_length[3]|max_length[100]',
            'description'    => 'permit_empty|max_length[500]',
            'price_per_hour' => 'required|numeric|greater_than[0]',
            'image'          => 'if_exist|uploaded[image]|max_size[image,2048]|is_image[image]',
            'status'         => 'required|in_list[Tersedia,Perawatan]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $imageName = $file->getRandomName();
            $file->move(ROOTPATH . 'image/lapangan', $imageName); 
            $imageName = 'image/lapangan/' . $imageName; 
        }

        $data = [
            'name'           => $this->request->getPost('name'),
            'description'    => $this->request->getPost('description'),
            'price_per_hour' => $this->request->getPost('price_per_hour'),
            'image'          => $imageName,
            'status'         => $this->request->getPost('status'),
        ];

        if ($this->lapanganModel->insert($data)) { 
            return redirect()->to(base_url('admin/lapangan'))->with('success', 'Lapangan berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan lapangan.');
        }
    }

    public function edit($id = null)
    {
        $lapangan = $this->lapanganModel->find($id); 

        if (! $lapangan) { 
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lapangan tidak ditemukan: ' . $id);
        }

        $data = [
            'title' => 'Edit Lapangan: ' . $lapangan['name'], 
            'lapangan' => $lapangan, 
        ];
        return view('admin/lapangan/form', $data); 
    }

    public function update($id = null)
    {
        $lapangan = $this->lapanganModel->find($id); 
        if (! $lapangan) { 
            return redirect()->back()->with('error', 'Lapangan tidak ditemukan.');
        }

        $rules = [
            'name'           => 'required|min_length[3]|max_length[100]',
            'description'    => 'permit_empty|max_length[500]',
            'price_per_hour' => 'required|numeric|greater_than[0]',
            'image'          => 'if_exist|uploaded[image]|max_size[image,2048]|is_image[image]',
            'status'         => 'required|in_list[Tersedia,Perawatan,Penuh]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = $lapangan['image'];
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
          
            if ($imageName && file_exists(ROOTPATH . 'public/' . $imageName)) {
                unlink(ROOTPATH . 'public/' . $imageName);
            }
            $imageName = $file->getRandomName();
            $file->move(ROOTPATH . 'image/lapangan', $imageName);
            $imageName = 'image/lapangan/' . $imageName; 
        }

        $data = [
            'name'           => $this->request->getPost('name'),
            'description'    => $this->request->getPost('description'),
            'price_per_hour' => $this->request->getPost('price_per_hour'),
            'image'          => $imageName,
            'status'         => $this->request->getPost('status'),
        ];

        if ($this->lapanganModel->update($id, $data)) { 
            return redirect()->to(base_url('admin/lapangan'))->with('success', 'Lapangan berhasil diperbarui.'); 
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui lapangan.');
        }
    }

    public function delete($id = null)
    {
        $lapangan = $this->lapanganModel->find($id); 
        if (! $lapangan) { 
            return redirect()->back()->with('error', 'Lapangan tidak ditemukan.');
        }

       
        if ($lapangan['image'] && file_exists(ROOTPATH . 'public/' . $lapangan['image'])) { 
            unlink(ROOTPATH . 'public/' . $lapangan['image']); 
        }

        if ($this->lapanganModel->delete($id)) { 
            return redirect()->to(base_url('admin/lapangan'))->with('success', 'Lapangan berhasil dihapus.'); 
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus lapangan.');
        }
    }
}
