<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
        ]);

        // Create sample divisions
        $divisis = [
            ['nama' => 'IT'],
            ['nama' => 'HR'],
            ['nama' => 'Finance'],
            ['nama' => 'Marketing'],
        ];

        foreach ($divisis as $divisi) {
            Divisi::create($divisi);
        }

        // Create sample members
        $anggotas = [
            ['nama' => 'John Doe', 'divisi_id' => 1],
            ['nama' => 'Jane Smith', 'divisi_id' => 1],
            ['nama' => 'Bob Johnson', 'divisi_id' => 2],
            ['nama' => 'Alice Brown', 'divisi_id' => 2],
            ['nama' => 'Charlie Wilson', 'divisi_id' => 3],
            ['nama' => 'Diana Miller', 'divisi_id' => 3],
            ['nama' => 'Edward Davis', 'divisi_id' => 4],
            ['nama' => 'Fiona Clark', 'divisi_id' => 4],
        ];

        foreach ($anggotas as $anggota) {
            Anggota::create($anggota);
        }
    }
}
