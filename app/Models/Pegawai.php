<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'nama',
        'alamat',
        'no_hp',
        'bagian',
        'username',
        'password',
        'id_jabatan',
        'id_shift',
    ];

    protected $hidden = [
        'password',
    ];
}
