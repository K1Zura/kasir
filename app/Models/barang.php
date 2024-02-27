<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;
    protected $fillable=[
        'kode_barang',
        'nama',
        'harga',
        'stok',
        'tanggal',
    ];

    public function barang()
{
    return $this->belongsTo(Barang::class, 'barang_id');
}
}
