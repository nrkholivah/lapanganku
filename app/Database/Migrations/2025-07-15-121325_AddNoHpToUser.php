<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNoHpToUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20, // Sesuaikan panjanh sesuai kebutuhan
                'unique'    => true, // Pastikan nomor HP unik
                'null'       => true, // Bisa diubah ke false jika wajib diisi
                'after'      => 'email', // Kolom ini akan ditambahkan setelah kolom 'email'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'no_hp');
    }
}
