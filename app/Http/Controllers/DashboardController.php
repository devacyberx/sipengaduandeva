<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'menunggu')->count();
        $processingComplaints = Complaint::where('status', 'diproses')->count();
        $completedComplaints = Complaint::where('status', 'selesai')->count();
        $totalStudents = User::where('role', 'siswa')->count();

        $monthlyStats = Complaint::selectRaw('
            MONTH(created_at) as month,
            COUNT(*) as total,
            SUM(CASE WHEN status = "selesai" THEN 1 ELSE 0 END) as completed
        ')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->get();

        $recentComplaints = Complaint::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

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
        $user = auth()->user();
        $totalComplaints = $user->complaints()->count();
        $pendingComplaints = $user->complaints()->where('status', 'menunggu')->count();
        $processingComplaints = $user->complaints()->where('status', 'diproses')->count();
        $completedComplaints = $user->complaints()->where('status', 'selesai')->count();

        $recentComplaints = $user->complaints()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'totalComplaints',
            'pendingComplaints',
            'processingComplaints',
            'completedComplaints',
            'recentComplaints'
        ));
    }
}