<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $fillable=[
        'kode_transaksi',
        'nama_pelanggan',
        'bayar',
        'dibayar',
        'kembalian',
        'tanggal',
    ];
}
