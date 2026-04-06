<?php

namespace App\Models;

// Untuk factory (testing)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Base model Laravel
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'title',         // judul pengaduan
        'description',   // isi/deskripsi
        'user_id',       // relasi ke user
        'category_id',   // relasi ke kategori
        'status',        // status pengaduan
        'photo',         // foto bukti
        'location',      // lokasi
        'fix_photo',     // foto perbaikan
        'processed_at',  // waktu diproses
        'completed_at',  // waktu selesai
    ];

    // Casting tipe data
    protected $casts = [
        'processed_at' => 'datetime', // otomatis jadi format tanggal
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        // Relasi: banyak complaint milik 1 user
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        // Relasi: banyak complaint milik 1 kategori
        return $this->belongsTo(Category::class);
    }

    public function feedbacks()
    {
        // Relasi: 1 complaint punya banyak feedback
        return $this->hasMany(Feedback::class);
    }

    public function latestFeedback()
    {
        // Ambil 1 feedback terbaru
        return $this->hasOne(Feedback::class)->latest();
    }

    public function getStatusColorAttribute()
    {
        // Accessor: menentukan warna berdasarkan status
        return match($this->status) {
            'menunggu' => 'warning',
            'diproses' => 'primary',
            'selesai' => 'success',
            'ditolak' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusTextAttribute()
    {
        // Accessor: ubah huruf pertama jadi kapital
        return ucfirst($this->status);
    }
}