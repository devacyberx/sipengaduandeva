<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks'; // ⬅️ WAJIB

    protected $fillable = [
        'complaint_id',
        'admin_id',
        'message',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
