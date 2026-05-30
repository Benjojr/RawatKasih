<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::create([
            'nama_lengkap' => 'Admin Panti',
            'email' => 'admin@rawatkasih.com',
            'password' => Hash::make('admin123'),
            'peran' => 'admin',
            'no_telpon' => '081234567890',
        ]);
    }
}
