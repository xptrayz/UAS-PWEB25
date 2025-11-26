<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@futsal.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        
        User::create([
            'name' => 'John Doe',
            'email' => 'member@futsal.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '082345678901',
        ]);

        
        $lapangans = [
            [
                'nama' => 'Lapangan A - Premium',
                'jenis' => 'Sintetis',
                'harga_per_jam' => 200000,
                'deskripsi' => 'Lapangan sintetis berkualitas tinggi dengan rumput import. Dilengkapi dengan lampu sorot LED dan sistem drainase modern.',
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Lapangan B - Standard',
                'jenis' => 'Vinyl',
                'harga_per_jam' => 150000,
                'deskripsi' => 'Lapangan vinyl yang nyaman untuk bermain. Cocok untuk latihan tim atau pertandingan persahabatan.',
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Lapangan C - VIP',
                'jenis' => 'Rumput Asli',
                'harga_per_jam' => 300000,
                'deskripsi' => 'Lapangan rumput asli dengan perawatan terbaik. Memberikan pengalaman bermain seperti di stadion profesional.',
                'status' => 'Tersedia',
            ],
            [
                'nama' => 'Lapangan D - Indoor',
                'jenis' => 'Sintetis',
                'harga_per_jam' => 250000,
                'deskripsi' => 'Lapangan indoor dengan AC. Nyaman dimainkan kapan saja tanpa terpengaruh cuaca.',
                'status' => 'Tersedia',
            ],
        ];

        foreach ($lapangans as $lapangan) {
            Lapangan::create($lapangan);
        }
    }
}