<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin / Demo User
        $user = User::create([
            'name' => 'Demo User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Demo Client
        $client = Client::create([
            'name' => 'PT Teknologi Jaya',
            'email' => 'contact@teknologijaya.com',
            'phone' => '081234567890',
            'notes' => 'Klien utama pengembangan sistem',
        ]);

        // Demo Projects
        $project1 = Project::create([
            'client_id' => $client->id,
            'title' => 'Pengembangan Sistem Kasir Web',
            'type' => 'aplikasi',
            'status' => 'in_progress',
            'deadline' => now()->addDays(14),
            'estimated_hours' => 40,
        ]);

        $project2 = Project::create([
            'client_id' => $client->id,
            'title' => 'Joki Tugas Algoritma Pemrograman',
            'type' => 'joki',
            'status' => 'todo',
            'deadline' => now()->addDays(3),
            'estimated_hours' => 8,
        ]);

        // Demo Transactions
        Transaction::create([
            'project_id' => $project1->id,
            'type' => 'income',
            'amount' => 2500000,
            'description' => 'Pembayaran DP 50%',
            'transaction_date' => now(),
        ]);
    }
}
