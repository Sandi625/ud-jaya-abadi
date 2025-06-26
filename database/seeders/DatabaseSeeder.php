<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
     public function run(): void
    {
      // Admin
    User::factory()->create([
        'id' => 1,
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin'),
        'level' => 'admin',
    ]);

    // Pelanggan
    User::factory()->create([
        'id' => 2,
        'name' => 'John Doe',
        'email' => 'user@example.com',
        'password' => bcrypt('user123'),
        'level' => 'pelanggan',
    ]);

    // Guide users
    User::factory()->create([
        'id' => 4,
        'name' => 'Dani',
        'email' => 'dani@example.com',
        'password' => bcrypt('password'),
        'level' => 'guide',
    ]);

    User::factory()->create([
        'id' => 5,
        'name' => 'Richard',
        'email' => 'richard@example.com',
        'password' => bcrypt('password'),
        'level' => 'guide',
    ]);

    User::factory()->create([
        'id' => 6,
        'name' => 'Yohanes',
        'email' => 'yohanes@example.com',
        'password' => bcrypt('password'),
        'level' => 'guide',
    ]);

    User::factory()->create([
        'id' => 7,
        'name' => 'Putri',
        'email' => 'putri@example.com',
        'password' => bcrypt('password'),
        'level' => 'guide',
    ]);

    User::factory()->create([
        'id' => 8,
        'name' => 'Duwik',
        'email' => 'duwik@example.com',
        'password' => bcrypt('password'),
        'level' => 'guide',
    ]);


        // Menjalankan semua seeder yang telah Anda buat
        $this->call([
            // KriteriaSeeder::class,
            // SubkriteriaSeeder::class,
            // PaketSeeder::class,
            // GuideSeeder::class,
            // PesananSeeder::class,
            // PenilaiansSeeder::class,
            // DetailPenilaiansSeeder::class,
        ]);
    }
}
