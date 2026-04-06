<?php

namespace App\Http\Controllers;

// Import model (hubungan ke database)
use App\Models\Complaint;
use App\Models\Category;
use App\Models\Feedback;

// Untuk ambil input dari user
use Illuminate\Http\Request;

// Untuk upload & hapus file
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    // ==============================
    // ADMIN SECTION
    // ==============================

    public function adminIndex(Request $request)
    {
        // Ambil data complaint + relasi (user, kategori, feedback)
        $query = Complaint::with(['user', 'category', 'latestFeedback']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter berdasarkan bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Search judul / deskripsi (LIKE untuk pencarian)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Urutkan terbaru + pagination
        $complaints = $query->latest()->paginate(10);

        // Ambil semua kategori
        $categories = Category::all();

        // Kirim ke view
        return view('admin.complaints.index', compact('complaints', 'categories'));
    }

    public function adminShow(Complaint $complaint)
    {
        // Load relasi tambahan
        $complaint->load(['user', 'category', 'feedbacks.admin']);

        // Tampilkan detail
        return view('admin.complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        // Update status
        $complaint->status = $request->status;

        // IF kondisi → set waktu diproses
        if ($request->status === 'diproses') {
            $complaint->processed_at = now();
        }

        // IF kondisi → set waktu selesai
        if ($request->status === 'selesai') {
            $complaint->completed_at = now();
        }

        // Simpan ke database
        $complaint->save();

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function addFeedback(Request $request, Complaint $complaint)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Simpan feedback ke database
        Feedback::create([
            'complaint_id' => $complaint->id,
            'admin_id'     => auth()->id(), // ambil user login
            'message'      => $request->message,
        ]);

        return redirect()->back()->with('success', 'Tanggapan berhasil ditambahkan.');
    }

    public function uploadFixPhoto(Request $request, Complaint $complaint)
    {
        // Validasi file gambar
        $request->validate([
            'fix_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cek apakah ada file
        if ($request->hasFile('fix_photo')) {

            // Hapus foto lama jika ada
            if ($complaint->fix_photo) {
                Storage::disk('public')->delete($complaint->fix_photo);
            }

            // Simpan foto baru
            $path = $request->file('fix_photo')->store('fix_photos', 'public');

            // Update database
            $complaint->fix_photo = $path;
            $complaint->save();
        }

        return redirect()->back()->with('success', 'Foto perbaikan berhasil diupload.');
    }


    // ==============================
    // SISWA SECTION
    // ==============================

    public function siswaIndex(Request $request)
    {
        // Ambil complaint milik user login
        $query = auth()->user()->complaints()
            ->with(['category', 'latestFeedback']);

        // Daftar status yang diperbolehkan
        $allowedStatus = ['menunggu', 'diproses', 'selesai', 'ditolak'];

        // Filter status + validasi array
        if ($request->filled('status') && in_array($request->status, $allowedStatus)) {
            $query->where('status', $request->status);
        }

        // Search data
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Pagination
        $complaints = $query->latest()->paginate(10);

        return view('siswa.complaints.index', compact('complaints'));
    }

    public function create()
    {
        // Ambil kategori untuk form
        $categories = Category::all();

        // Tampilkan form input
        return view('siswa.complaints.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input user
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location'    => 'nullable|string|max:255',
        ]);

        // Ambil data dari request
        $data = $request->only(['title', 'category_id', 'description', 'location']);

        // Tambahkan user login
        $data['user_id'] = auth()->id();

        // Set status awal
        $data['status']  = 'menunggu';

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('complaint_photos', 'public');
        }

        // Simpan ke database
        Complaint::create($data);

        return redirect()->route('siswa.complaints.index')
            ->with('success', 'Pengaduan berhasil dibuat.');
    }

    public function siswaShow(Complaint $complaint)
    {
        // Keamanan: hanya user sendiri
        if ($complaint->user_id !== auth()->id()) {
            abort(403); // forbidden
        }

        // Load relasi
        $complaint->load(['category', 'feedbacks.admin']);

        return view('siswa.complaints.show', compact('complaint'));
    }

    public function history()
    {
        // Ambil semua riwayat complaint user
        $complaints = auth()->user()->complaints()
            ->with('category')
            ->latest()
            ->get();

        return view('siswa.history.index', compact('complaints'));
    }
}