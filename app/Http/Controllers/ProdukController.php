<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\history;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;

class ProdukController extends Controller
{
    public function produk(){
        $produk = barang::get();
        return view('/produk', ['produk'=>$produk]);
    }
    public function delete($id){
        $today = date('Y-m-d');
        $produk = barang::findOrFail($id);
        try {
            $produk->delete();
            history::create([
                'tanggal' => $today,
                'keterangan' => 'Hapus Barang',
            ]);
            return redirect('/produk')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/produk')->with('error', 'Terjadi kesalahan dalam menghapus data.');
        }
    }

}
