<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat user siswa contoh
        User::create([
            'name' => 'User',
            'email' => 'User@siswa.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        // Buat kategori aspirasi
        $kategoris = [
            ['nama_kategori' => 'Fasilitas Sekolah', 'deskripsi' => 'Keluhan/saran fasilitas sekolah'],
            ['nama_kategori' => 'Akademik', 'deskripsi' => 'Masalah pembelajaran dan kurikulum'],
            ['nama_kategori' => 'Ekstrakurikuler', 'deskripsi' => 'Kegiatan di luar jam pelajaran'],
            ['nama_kategori' => 'Kesiswaan', 'deskripsi' => 'Masalah administrasi dan keorganisasian'],
            ['nama_kategori' => 'Kebersihan', 'deskripsi' => 'Kebersihan lingkungan sekolah'],
            ['nama_kategori' => 'Keamanan', 'deskripsi' => 'Keamanan dan ketertiban sekolah'],
            ['nama_kategori' => 'Lainnya', 'deskripsi' => 'Aspirasi lainnya'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
