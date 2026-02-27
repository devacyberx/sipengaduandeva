<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Category;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    // ==============================
    // ADMIN SECTION
    // ==============================

    public function adminIndex(Request $request)
    {
        $query = Complaint::with(['user', 'category', 'latestFeedback']);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Search judul/deskripsi
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $complaints = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.complaints.index', compact('complaints', 'categories'));
    }

    public function adminShow(Complaint $complaint)
    {
        $complaint->load(['user', 'category', 'feedbacks.admin']);
        return view('admin.complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        $complaint->status = $request->status;

        if ($request->status === 'diproses') {
            $complaint->processed_at = now();
        }

        if ($request->status === 'selesai') {
            $complaint->completed_at = now();
        }

        $complaint->save();

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function addFeedback(Request $request, Complaint $complaint)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'complaint_id' => $complaint->id,
            'admin_id'     => auth()->id(),
            'message'      => $request->message,
        ]);

        return redirect()->back()->with('success', 'Tanggapan berhasil ditambahkan.');
    }

    public function uploadFixPhoto(Request $request, Complaint $complaint)
    {
        $request->validate([
            'fix_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('fix_photo')) {

            // Hapus foto lama jika ada
            if ($complaint->fix_photo) {
                Storage::disk('public')->delete($complaint->fix_photo);
            }

            $path = $request->file('fix_photo')->store('fix_photos', 'public');
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
        $query = auth()->user()->complaints()
            ->with(['category', 'latestFeedback']);

        $allowedStatus = ['menunggu', 'diproses', 'selesai', 'ditolak'];

        // Filter status
        if ($request->filled('status') && in_array($request->status, $allowedStatus)) {
            $query->where('status', $request->status);
        }

        // Optional search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $complaints = $query->latest()->paginate(10);

        return view('siswa.complaints.index', compact('complaints'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('siswa.complaints.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location'    => 'nullable|string|max:255',
        ]);

        $data = $request->only(['title', 'category_id', 'description', 'location']);
        $data['user_id'] = auth()->id();
        $data['status']  = 'menunggu';

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('complaint_photos', 'public');
        }

        Complaint::create($data);

        return redirect()->route('siswa.complaints.index')
            ->with('success', 'Pengaduan berhasil dibuat.');
    }

    public function siswaShow(Complaint $complaint)
    {
        // Cegah akses complaint orang lain
        if ($complaint->user_id !== auth()->id()) {
            abort(403);
        }

        $complaint->load(['category', 'feedbacks.admin']);

        return view('siswa.complaints.show', compact('complaint'));
    }

    public function history()
    {
        $complaints = auth()->user()->complaints()
            ->with('category')
            ->latest()
            ->get();

        return view('siswa.history.index', compact('complaints'));
    }
}