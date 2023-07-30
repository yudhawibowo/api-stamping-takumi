<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
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

    public function jabatan(): BelongsTo 
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan' , 'id');        
    }

    // public function shift() : BelongsTo 
    // {
    //     return $this->belongsTo(Shift::class, 'id_shift' , 'id');        
    // }
}
