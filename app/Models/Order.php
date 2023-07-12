<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_order',
        'id_customer',
        'po_number',
        'quotation_number',
        'so_number',
        'product_name',
        'product_number',
        'qty',
        'material_supply',
        'internal_order_number',
        'notes',
        'upload_file',
        'id_pegawai',

    ];
}
