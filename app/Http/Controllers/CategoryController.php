<?php

namespace App\Http\Controllers;

// Model kategori (hubungan ke database)
use App\Models\Category;

// Untuk ambil input dari user
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil data kategori, urut terbaru + pagination
        $categories = Category::latest()->paginate(10);

        // Kirim ke view
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        // Menampilkan form tambah kategori
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:categories', // nama harus unik
            'description' => 'nullable|string',
            'color' => 'required|string|max:7', // biasanya kode warna HEX
        ]);

        // Simpan ke database
        Category::create($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        // Tampilkan form edit
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Validasi input (nama tetap unik kecuali data sendiri)
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
        ]);

        // Update data kategori
        $category->update($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Cek apakah kategori masih dipakai di complaint
        if ($category->complaints()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki pengaduan.');
        }

        // Hapus data
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}