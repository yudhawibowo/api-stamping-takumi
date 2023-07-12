<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_material',
        'product_name',
        'product_number',
        'p1',
        'l',
        't',
        'd',
        'p2',
        'qty',
    ];
}
