<?php

namespace App\Http\Controllers;

// Model untuk ambil data dari database
use App\Models\Complaint;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Hitung total semua pengaduan
        $totalComplaints = Complaint::count();

        // Hitung berdasarkan status
        $pendingComplaints = Complaint::where('status', 'menunggu')->count();
        $processingComplaints = Complaint::where('status', 'diproses')->count();
        $completedComplaints = Complaint::where('status', 'selesai')->count();

        // Hitung jumlah siswa
        $totalStudents = User::where('role', 'siswa')->count();

        // Statistik bulanan (query custom)
        $monthlyStats = Complaint::selectRaw('
            MONTH(created_at) as month,
            COUNT(*) as total,
            SUM(CASE WHEN status = "selesai" THEN 1 ELSE 0 END) as completed
        ')
        ->whereYear('created_at', date('Y')) // filter tahun sekarang
        ->groupBy('month') // grouping per bulan
        ->get();

        // Ambil 10 pengaduan terbaru
        $recentComplaints = Complaint::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        // Kirim ke view dashboard admin
        return view('admin.dashboard', compact(
            'totalComplaints',
            'pendingComplaints',
            'processingComplaints',
            'completedComplaints',
            'totalStudents',
            'monthlyStats',
            'recentComplaints'
        ));
    }

    public function siswaDashboard()
    {
        // Ambil user yang login
        $user = auth()->user();

        // Hitung data milik user
        $totalComplaints = $user->complaints()->count();
        $pendingComplaints = $user->complaints()->where('status', 'menunggu')->count();
        $processingComplaints = $user->complaints()->where('status', 'diproses')->count();
        $completedComplaints = $user->complaints()->where('status', 'selesai')->count();

        // Ambil 5 pengaduan terbaru milik user
        $recentComplaints = $user->complaints()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        // Kirim ke view dashboard siswa
        return view('siswa.dashboard', compact(
            'totalComplaints',
            'pendingComplaints',
            'processingComplaints',
            'completedComplaints',
            'recentComplaints'
        ));
    }
}