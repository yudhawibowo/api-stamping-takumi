<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_mesin',
        'nama_mesin',
        'tonase',
        'sph',
        'capacity',
        'status_mesin',
    ];
}
