<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\pembelian;
use App\Models\transaksi;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(){
        return view('/login');
    }

    public function auth(Request $request){
        $request->validate([
            'email'=>['required'],
            'password'=>['required'],
        ]);
        $infoLogin=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if (Auth::attempt($infoLogin)) {
            return redirect('/');
        }else {
            return redirect('/login');
        }
    }

    public function index(){
        $today = date('Y-m-d');
        $total_pembayaran = transaksi::whereDate('tanggal', $today)->sum('bayar');
        $total_pembelian = pembelian::whereDate('tanggal', $today)->sum('harga');

        return view('/home', compact('total_pembayaran', 'total_pembelian'));
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
