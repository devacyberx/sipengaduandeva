<?php

namespace App\Models;

// Trait untuk factory
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Base auth Laravel (bisa login)
use Illuminate\Foundation\Auth\User as Authenticatable;

// Untuk notifikasi
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Mengaktifkan fitur factory & notifikasi
    use HasFactory, Notifiable;

    // Field yang boleh diisi
    protected $fillable = [
        'name',     // nama user
        'email',    // email
        'password', // password
        'role',     // role (admin / siswa)
        'phone',    // nomor HP
        'class',    // kelas (untuk siswa)
        'avatar',   // foto profil
    ];

    // Field yang disembunyikan (keamanan)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting tipe data
    protected $casts = [
        'email_verified_at' => 'datetime', // format tanggal
        'password' => 'hashed', // otomatis di-hash
    ];

    public function complaints()
    {
        // Relasi: 1 user punya banyak complaint
        return $this->hasMany(Complaint::class);
    }

    public function feedbacks()
    {
        // Relasi: 1 admin punya banyak feedback
        return $this->hasMany(Feedback::class, 'admin_id');
    }

    public function isAdmin()
    {
        // Cek apakah role admin
        return $this->role === 'admin';
    }

    public function isSiswa()
    {
        // Cek apakah role siswa
        return $this->role === 'siswa';
    }
}