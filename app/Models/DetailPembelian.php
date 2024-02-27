<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $fillable=[
        'nama',
        'kode_barang',
        'harga',
        'jumlah',
        'pembelian_id',
    ];
}
