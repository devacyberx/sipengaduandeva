<?php

namespace App\Models;

// Trait untuk factory (biasanya untuk testing / dummy data)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Base model Laravel (untuk database)
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Mengaktifkan factory
    use HasFactory;

    // Field yang boleh diisi (mass assignment)
    protected $fillable = [
        'name',        // nama kategori
        'description', // deskripsi kategori
        'color',       // warna kategori (biasanya HEX)
    ];

    public function complaints()
    {
        // Relasi One to Many (1 kategori punya banyak complaint)
        return $this->hasMany(Complaint::class);
    }
}