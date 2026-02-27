<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sipengaduan.id',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Create sample students
        $students = [
            ['name' => 'Ahmad Rizki', 'email' => 'ahmad@sipengaduan.id', 'class' => 'XII RPL 1'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti@sipengaduan.id', 'class' => 'XII RPL 1'],
            ['name' => 'Budi Santoso', 'email' => 'budi@sipengaduan.id', 'class' => 'XII RPL 2'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@sipengaduan.id', 'class' => 'XII RPL 2'],
            ['name' => 'Rio Ferdiansyah', 'email' => 'rio@sipengaduan.id', 'class' => 'XII RPL 3'],
        ];

        foreach ($students as $student) {
            User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make('12345678'),
                'role' => 'siswa',
                'class' => $student['class'],
                'phone' => '08' . rand(1000000000, 9999999999),
            ]);
        }

        // Create categories
        $categories = [
            ['name' => 'Kursi & Meja', 'color' => '#0d6efd', 'description' => 'Kerusakan kursi dan meja'],
            ['name' => 'Papan Tulis', 'color' => '#198754', 'description' => 'Masalah papan tulis'],
            ['name' => 'Proyektor', 'color' => '#6f42c1', 'description' => 'Kerusakan proyektor'],
            ['name' => 'AC & Ventilasi', 'color' => '#fd7e14', 'description' => 'Masalah pendingin ruangan'],
            ['name' => 'Listrik & Lampu', 'color' => '#dc3545', 'description' => 'Masalah kelistrikan'],
            ['name' => 'Toilet', 'color' => '#20c997', 'description' => 'Masalah fasilitas toilet'],
            ['name' => 'Internet', 'color' => '#0dcaf0', 'description' => 'Masalah jaringan internet'],
            ['name' => 'Lainnya', 'color' => '#6c757d', 'description' => 'Kategori lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample complaints
        $statuses = ['menunggu', 'diproses', 'selesai'];
        $users = User::where('role', 'siswa')->get();
        $categories = Category::all();

        foreach ($users as $user) {
            for ($i = 1; $i <= rand(2, 5); $i++) {
                $complaint = Complaint::create([
                    'title' => 'Pengaduan ' . $i . ' - ' . $user->name,
                    'description' => 'Deskripsi pengaduan contoh untuk ' . $user->name . '. ' . 
                                   'Ini adalah contoh pengaduan sistem pengaduan sarana sekolah.',
                    'user_id' => $user->id,
                    'category_id' => $categories->random()->id,
                    'status' => $statuses[array_rand($statuses)],
                    'location' => 'Ruangan ' . rand(1, 10),
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);

                // Create feedback for some complaints
                if (in_array($complaint->status, ['diproses', 'selesai'])) {
                    Feedback::create([
                        'complaint_id' => $complaint->id,
                        'admin_id' => User::where('role', 'admin')->first()->id,
                        'message' => 'Pengaduan sedang kami proses. Tim teknis akan segera menanganinya.',
                        'created_at' => $complaint->created_at->addDays(1),
                    ]);
                }
            }
        }
    }
}