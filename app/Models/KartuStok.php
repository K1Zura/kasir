<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartuStok extends Model
{
    use HasFactory;
    protected $fillable=[
        'tanggal',
        'barang_id',
        'keterangan',
        'masuk',
        'keluar',
        'jumlah',
    ];

    public function barang(){
        return $this->belongsTo(barang::class);
    }
}
