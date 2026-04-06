<?php

namespace App\Models;

// Base model Laravel
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    // Nama tabel (karena Laravel defaultnya 'feedback', jadi harus ditentukan)
    protected $table = 'feedbacks'; // WAJIB

    // Field yang boleh diisi
    protected $fillable = [
        'complaint_id', // relasi ke complaint
        'admin_id',     // relasi ke admin (user)
        'message',      // isi feedback
    ];

    public function admin()
    {
        // Relasi: feedback dibuat oleh 1 admin (user)
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function complaint()
    {
        // Relasi: feedback milik 1 complaint
        return $this->belongsTo(Complaint::class);
    }
}