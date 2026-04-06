<?php

namespace App\Http\Controllers;

// Model untuk ambil data dari database
use App\Models\Complaint;
use App\Models\Category;

// Untuk ambil input dari user
use Illuminate\Http\Request;

// Library untuk generate PDF
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan
     */
    public function index(Request $request)
    {
        // Ambil data dengan filter (pakai function sendiri)
        $query = $this->filterReports($request);

        // Ambil semua data laporan, urut terbaru
        $reports = $query->latest()->get();

        // Ambil semua kategori
        $categories = Category::all();

        // Hitung total data
        $totalComplaints = $reports->count();

        // Hitung jumlah yang selesai
        $completedComplaints = $reports->where('status', 'selesai')->count();

        // Hitung persentase penyelesaian
        $completionRate = $totalComplaints > 0 
            ? round(($completedComplaints / $totalComplaints) * 100, 2) 
            : 0;

        // Kirim ke view
        return view('admin.reports.index', compact(
            'reports',
            'categories',
            'totalComplaints',
            'completedComplaints',
            'completionRate'
        ));
    }

    /**
     * Print laporan (langsung dari browser)
     */
    public function print(Request $request)
    {
        // Ambil data dengan filter
        $query = $this->filterReports($request);

        // Ambil data
        $reports = $query->latest()->get();

        // Tampilkan ke halaman print
        return view('admin.reports.print', compact('reports'));
    }

    /**
     * Download laporan dalam bentuk PDF
     */
    public function downloadPdf(Request $request)
    {
        // Ambil data dengan filter
        $query = $this->filterReports($request);
        $reports = $query->latest()->get();

        // Cek apakah data kosong
        if ($reports->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk di-download');
        }

        // Generate PDF dari view
        $pdf = Pdf::loadView('admin.reports.pdf', compact('reports'));
        
        // Atur ukuran kertas
        $pdf->setPaper('A4', 'landscape');
        
        // Setting tambahan PDF
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        // Buat nama file otomatis
        $filename = 'laporan_pengaduan_' . date('Y-m-d_His') . '.pdf';

        // Download file PDF
        return $pdf->download($filename);
    }

    /**
     * Function untuk filter data laporan
     */
    private function filterReports(Request $request)
    {
        // Ambil data complaint + relasi
        $query = Complaint::with(['user', 'category']);

        // Filter berdasarkan bulan
        if ($request->filled('month') && $request->month != '' && $request->month != 'all') {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter berdasarkan tahun
        if ($request->filled('year') && $request->year != '' && $request->year != 'all') {
            $query->whereYear('created_at', $request->year);
        }

        // Filter kategori
        if ($request->filled('category') && $request->category != '' && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Filter status
        if ($request->filled('status') && $request->status != '' && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Kembalikan query
        return $query;
    }
}