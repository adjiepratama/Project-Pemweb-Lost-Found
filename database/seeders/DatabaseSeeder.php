<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- HAPUS ATAU KOMENTARI BAGIAN INI (INI PENYEBAB ERROR) ---
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // -------------------------------------------------------------

        // --- GANTI DENGAN INI ---
        $this->call([
            AdminSeeder::class,
        ]);
    }
}