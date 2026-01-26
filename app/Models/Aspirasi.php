<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'status',
        'is_anonim',
        'lokasi',
    ];

    // Relationship dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relationship dengan progress
    public function progress()
    {
        return $this->hasMany(Progress::class)->orderBy('created_at', 'desc');
    }

    // Relationship dengan umpan balik
    public function umpanBaliks()
    {
        return $this->hasMany(UmpanBalik::class)->orderBy('created_at', 'desc');
    }

    // Accessor untuk nama siswa (anonim atau tidak)
    public function getNamaSiswaAttribute()
    {
        return $this->is_anonim ? 'Anonim' : $this->user->name;
    }

    // Accessor untuk warna status
    public function getStatusColorAttribute()
    {
        $colors = [
            'menunggu' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
