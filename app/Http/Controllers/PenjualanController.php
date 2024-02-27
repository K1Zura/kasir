<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\history;
use App\Models\KartuStok;
use App\Models\transaksi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\Session;


class PenjualanController extends Controller
{
    public function penjualan(Request $request){
        $detailPenjualan = Session::get('detailPenjualan', []);
        $produk = Barang::get();

        foreach ($detailPenjualan as $index => $item) {
            $barang = $produk->firstWhere('id', $item['barang_id']);
            if ($barang) {
                $detailPenjualan[$index]['nama'] = $barang->nama;
            }
        }

        return view('/penjualan', compact('produk', 'detailPenjualan'));
    }

    public function tambahBarang(Request $request) {
        $barangId = $request->input('barang_id');
        $product = barang::findOrFail($barangId);

        $detailPenjualan = Session::get('detailPenjualan', []);
        $barang = array_search($barangId, array_column($detailPenjualan, 'barang_id'));

        if ($barang !== false) {
            $detailPenjualan[$barang]['jumlah'] += $request->input('jumlah');
        } else {
            $detailPenjualan[] = [
                'barang_id' => $product->id,
                'nama' => $product->nama,
                'jumlah' => $request->input('jumlah'),
                'harga' => $product->harga,
            ];
        }

        Session::put('detailPenjualan', $detailPenjualan);

        return redirect()->back();
    }

    public function delete($id) {
        $detailPenjualan = Session::get('detailPenjualan', []);
        $detailPenjualan = array_filter($detailPenjualan, function ($detail) use ($id) {
            return $detail['barang_id'] != $id;
        });
        Session::put('detailPenjualan', $detailPenjualan);

        return redirect('/penjualan');
    }

    public function update(Request $request) {
        $barangId = $request->input('barang_id');
        $jumlahBaru = $request->input('jumlah');
        $barang = Barang::findOrFail($barangId);

        if ($jumlahBaru <= $barang->stok) {
            $detailPenjualan = collect(Session::get('detailPenjualan', []));
            $detailPenjualan = $detailPenjualan->map(function ($item) use ($barangId, $jumlahBaru) {
                if ($item['barang_id'] == $barangId) {
                    $item['jumlah'] = $jumlahBaru;
                }
                return $item;
            });

            Session::put('detailPenjualan', $detailPenjualan->toArray());
        } else {
            return redirect()->back()->with('error', 'Jumlah barang yang diminta melebihi stok yang tersedia.');
        }

        return redirect()->back();
    }


    public function tambahPenjualan(Request $request)
    {
        if ($request->input('action') === 'bayar') {
            $validated = $request->validate([
                'nama_pelanggan' => 'required',
                'bayar' => 'required|numeric|min:1',
                'dibayar' => 'required',
                'kembalian' => 'required|numeric|min:0',
                'tanggal' => 'required|',
            ],[
                'nama_pelanggan.required' => 'Masukkan Nama!!',
                'bayar.required' => 'Masukkan Barang!!',
                'dibayar.required' => 'Masukkan Uang Anda!!',
                'kembalian.required' => 'Masukkan Uang Dulu!!',
                'tanggal.required' => 'Masukkan Tanggal Dulu!!',
                'bayar.min' => 'Masukkan Barang Dulu!!',
                'kembalian.min' => 'Uang anda kurang!!',
            ]);

            $kode_transaksi = 'PB' . Str::random(8);

            $penjualanData = [
                'kode_transaksi' => $kode_transaksi,
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'bayar' => $request->input('bayar'),
                'dibayar' => $request->input('dibayar'),
                'kembalian' => $request->input('kembalian'),
                'tanggal' => $request->input('tanggal'),
            ];


            $transaksi = transaksi::create($penjualanData);
            $detailPenjualan = Session::get('detailPenjualan', []);

            foreach ($detailPenjualan as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                $today = date('Y-m-d');
                if ($barang->stok - $item['jumlah'] >= 0) {
                    $barang->stok -= $item['jumlah'];
                    $barang->save();

                    DetailPenjualan::create([
                        'nama' => $item['nama'],
                        'jumlah' => $item['jumlah'],
                        'harga' => $item['harga'],
                        'transaksi_id' => $transaksi->id,
                    ]);

                    history::create([
                        'tanggal' => $today,
                        'keterangan' => 'Penjualan Barang',
                    ]);

                    KartuStok::create([
                        'tanggal' => $transaksi->tanggal,
                        'barang_id' => $item['barang_id'],
                        'keterangan' => 'Penjualan Barang',
                        'masuk' => 0,
                        'keluar' => $item['jumlah'],
                        'jumlah' => $barang->stok,
                    ]);
                } else {
                    return redirect()->back()->with('error', 'Jumlah stok tidak mencukupi.');
                }
            }

            Session::forget('detailPenjualan');

            return redirect()->route('detailTransaksi', ['id' => $transaksi->id])->with('success', 'Transaksi anda berhasil.');
        } elseif ($request->input('action') === 'batal') {
            Session::forget('detailPenjualan');
            return redirect('/penjualan');
        }
    }

    public function show($id)
    {
        $transaksi = transaksi::findOrFail($id);
        return view('print.print-penjualan', compact('transaksi'));
    }
}
