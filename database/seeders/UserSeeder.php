<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Imam',
            'email' => 'imam@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Vania',
            'email' => 'vania@example.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        // Dosen
        User::create([
            'name' => 'Siti',
            'email' => 'siti@example.com',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);
    }
}