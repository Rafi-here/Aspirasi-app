<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship dengan aspirasi
    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class);
    }

    // Relationship dengan progress yang dibuat
    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    // Relationship dengan umpan balik
    public function umpanBaliks()
    {
        return $this->hasMany(UmpanBalik::class);
    }

    // Cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    // Cek apakah user adalah siswa
    public function isSiswa()
    {
        return $this->role == 'siswa';
    }
}
