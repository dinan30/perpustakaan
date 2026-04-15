<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
{
    // Akun Admin
    \App\Models\User::create([
        'name' => 'Admin Perpus',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    // Akun Peminjam (Siswa)
    \App\Models\User::create([
        'name' => 'Siswa Sekolah',
        'email' => 'siswa@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'peminjam',
    ]);
}
}
