<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // NAMESPACE YANG BENAR

class ReportController extends Controller
{
    /**
     * Display report page
     */
    public function index(Request $request)
    {
        $query = $this->filterReports($request);

        $reports = $query->latest()->get();
        $categories = Category::all();

        // Statistics
        $totalComplaints = $reports->count();
        $completedComplaints = $reports->where('status', 'selesai')->count();
        $completionRate = $totalComplaints > 0 
            ? round(($completedComplaints / $totalComplaints) * 100, 2) 
            : 0;

        return view('admin.reports.index', compact(
            'reports',
            'categories',
            'totalComplaints',
            'completedComplaints',
            'completionRate'
        ));
    }

    /**
     * Print report (browser printing)
     */
    public function print(Request $request)
    {
        $query = $this->filterReports($request);
        $reports = $query->latest()->get();

        return view('admin.reports.print', compact('reports'));
    }

    /**
     * Download report as PDF
     */
    public function downloadPdf(Request $request)
    {
        $query = $this->filterReports($request);
        $reports = $query->latest()->get();

        // Cek apakah ada data
        if ($reports->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk di-download');
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.reports.pdf', compact('reports'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');
        
        // Set options for better rendering
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        // Generate filename
        $filename = 'laporan_pengaduan_' . date('Y-m-d_His') . '.pdf';

        // Download the PDF
        return $pdf->download($filename);
    }

    /**
     * Filter Logic
     */
    private function filterReports(Request $request)
    {
        $query = Complaint::with(['user', 'category']);

        // Filter Bulan
        if ($request->filled('month') && $request->month != '' && $request->month != 'all') {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter Tahun
        if ($request->filled('year') && $request->year != '' && $request->year != 'all') {
            $query->whereYear('created_at', $request->year);
        }

        // Filter Kategori
        if ($request->filled('category') && $request->category != '' && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Filter Status
        if ($request->filled('status') && $request->status != '' && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        return $query;
    }
}