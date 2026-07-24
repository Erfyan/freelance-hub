<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\TimeLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. User Utama / Admin (Hanya 1 Akun sesuai instruksi aplikasi privat)
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Erfyan',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Data Klien Utama
        $client1 = Client::create([
            'name'  => 'PT Teknologi Nusantara',
            'email' => 'contact@teknus.co.id',
            'phone' => '081234567890',
            'notes' => 'Klien enterprise pengembangan aplikasi kasir & inventory.',
        ]);

        $client2 = Client::create([
            'name'  => 'CV Digital Solusindo',
            'email' => 'support@digisolu.com',
            'phone' => '085711223344',
            'notes' => 'Klien reguler untuk jasa pembuatan landing page & joki koding.',
        ]);

        $client3 = Client::create([
            'name'  => 'Toko Sembako Berkah',
            'email' => 'berkah.store@gmail.com',
            'phone' => '087799887766',
            'notes' => 'Pemilik UMKM lokal.',
        ]);

        // 3. Data Proyek (Client & Personal)
        
        // --- Proyek Klien ---
        $p1 = Project::create([
            'category'        => 'client',
            'client_id'       => $client1->id,
            'title'           => 'Pengembangan Sistem POS & Kasir Toko',
            'type'            => 'aplikasi',
            'status'          => 'in_progress',
            'deadline'        => now()->addDays(15),
            'estimated_hours' => 60,
            'budget'          => 5000000,
        ]);

        $p2 = Project::create([
            'category'        => 'client',
            'client_id'       => $client2->id,
            'title'           => 'Joki Tugas Akhir Laravel - System Restoran',
            'type'            => 'joki',
            'status'          => 'done',
            'deadline'        => now()->subDays(5),
            'estimated_hours' => 20,
            'budget'          => 1500000,
        ]);

        $p3 = Project::create([
            'category'        => 'client',
            'client_id'       => $client3->id,
            'title'           => 'Landing Page Promosi Toko Online',
            'type'            => 'aplikasi',
            'status'          => 'todo',
            'deadline'        => now()->addDays(10),
            'estimated_hours' => 15,
            'budget'          => 800000,
        ]);

        // --- Proyek Personal ---
        $p4 = Project::create([
            'category'        => 'personal',
            'client_id'       => null,
            'title'           => 'Pengembangan Freelance Hub Mobile & Web',
            'type'            => 'aplikasi',
            'status'          => 'in_progress',
            'deadline'        => now()->addDays(30),
            'estimated_hours' => 80,
            'budget'          => 0,
        ]);

        $p5 = Project::create([
            'category'        => 'personal',
            'client_id'       => null,
            'title'           => 'Eksperimen Fitur Biometrik Passkey (WebAuthn)',
            'type'            => 'aplikasi',
            'status'          => 'done',
            'deadline'        => now()->subDays(2),
            'estimated_hours' => 10,
            'budget'          => 0,
        ]);

        // 4. Data Transaksi Keuangan (Pemasukan & Pengeluaran)
        Transaction::create([
            'project_id'       => $p1->id,
            'type'             => 'income',
            'amount'           => 2500000,
            'description'      => 'Pembayaran DP 50% Proyek POS',
            'transaction_date' => now()->subDays(10),
        ]);

        Transaction::create([
            'project_id'       => $p1->id,
            'type'             => 'expense',
            'amount'           => 250000,
            'description'      => 'Sewa VPS Cloud & Domain .co.id',
            'transaction_date' => now()->subDays(8),
        ]);

        Transaction::create([
            'project_id'       => $p2->id,
            'type'             => 'income',
            'amount'           => 1500000,
            'description'      => 'Pelunasan Joki Sistem Restoran',
            'transaction_date' => now()->subDays(5),
        ]);

        // 5. Data Pelacakan Waktu (Time Logs)
        TimeLog::create([
            'project_id'       => $p1->id,
            'start_time'       => now()->subDays(3)->setHour(9)->setMinute(0),
            'end_time'         => now()->subDays(3)->setHour(12)->setMinute(30),
            'duration_minutes' => 210,
            'is_running'       => false,
            'note'             => 'Slicing UI dashboard & arsitektur database',
        ]);

        TimeLog::create([
            'project_id'       => $p2->id,
            'start_time'       => now()->subDays(6)->setHour(13)->setMinute(0),
            'end_time'         => now()->subDays(6)->setHour(17)->setMinute(15),
            'duration_minutes' => 255,
            'is_running'       => false,
            'note'             => 'Implementasi CRUD & Export PDF',
        ]);

        TimeLog::create([
            'project_id'       => $p4->id,
            'start_time'       => now()->subHours(2),
            'end_time'         => now()->subHours(1),
            'duration_minutes' => 60,
            'is_running'       => false,
            'note'             => 'Refactoring & pengujian unit otomatis',
        ]);
    }
}
