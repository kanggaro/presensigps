<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_karyawan';
    protected $primaryKey = 'k_nik';

    protected $fillable = [
        'k_nik',
        'k_nama_lengkap',
        'k_jabatan',
        'k_no_hp',
        'password',
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
}
