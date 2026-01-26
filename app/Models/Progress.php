<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspirasi_id',
        'user_id',
        'deskripsi',
        'tipe',
    ];

    // Relationship dengan aspirasi
    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    // Relationship dengan user (admin yang membuat progress)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk format waktu
    public function getWaktuFormatAttribute()
    {
        return $this->created_at->format('d M Y, H:i');
    }
}
