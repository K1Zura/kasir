<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\history;
use App\Models\KartuStok;
use App\Models\pembelian;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailPembelian;
use Illuminate\Support\Facades\Session;

class PembelianController extends Controller
{
    public function index(){
        $detailPembelian = Session::get('detailPembelian', []);
        $produk = Barang::get();

        foreach ($detailPembelian as $index => $item) {
            $barang = $produk->firstWhere('id', $item['barang_id']);
            if ($barang) {
                $detailPembelian[$index]['nama'] = $barang->nama;
            }
        }
        return view('/pembelian', compact('produk','detailPembelian'));
    }

    public function add(Request $request){
        if ($request->input('action') == 'simpanBarang') {
            $today = date('Y-m-d');
            $produk = barang::create($request->all());
            history::create([
                'tanggal' => $today,
                'keterangan' => 'Tambah Barang',
            ]);
            return redirect('/pembelian')->with('success', 'Barang baru sudah ditambahkan');
        }
        $barangId = $request->input('barang_id');
        $product = barang::findOrFail($barangId);

        $detailPembelian = Session::get('detailPembelian', []);
        $barang = array_search($barangId, array_column($detailPembelian, 'barang_id'));

        if ($barang !== false) {
            $detailPembelian[$barang]['jumlah'] += $request->input('jumlah');
        } else {
            $detailPembelian[] = [
                'barang_id' => $product->id,
                'nama' => $product->nama,
                'kode_barang' => $product->kode_barang,
                'jumlah' => $request->input('jumlah'),
                'harga' => $product->harga,
            ];
        }

        Session::put('detailPembelian', $detailPembelian);

        return redirect()->back();
    }

    public function delete($id){
        $detailPembelian = Session::get('detailPembelian', []);
        $detailPembelian = array_filter($detailPembelian, function ($detail) use ($id){
            return $detail['barang_id'] != $id;
        });
        Session::put('detailPembelian', $detailPembelian);
        return redirect('/pembelian');
    }

    public function put(Request $request){
        $barangId = $request->input('barang_id');
        $jumlahBaru = $request->input('jumlah');
        $barang = barang::findOrFail($barangId);
        $detailPembelian = collect(Session::get('detailPembelian', []));
        $detailPembelian = $detailPembelian->map(function ($item) use ($barangId, $jumlahBaru) {
            if ($item['barang_id'] == $barangId) {
                $item['jumlah'] = $jumlahBaru;
            }
            return $item;
        });

        Session::put('detailPembelian', $detailPembelian->toArray());

        return redirect()->back();
    }

    public function store(Request $request)
    {
        if ($request->input('action') == 'proses') {
            $validated = $request->validate([
                'nama' => 'required',
                'jumlah' => 'required|numeric|min:1',
                'harga' => 'required|numeric|min:1',
                'tanggal' => 'required',
            ], [
                'nama.required' => 'Masukkan Nama!!',
                'jumlah.required' => 'Masukkan Jumlah!!',
                'harga.required' => 'Masukkan Harga!!',
                'tanggal.required' => 'Masukkan Tanggal!!',
                'jumlah.min' => 'Masukkan Barang!!',
                'harga.min' => 'Masukkan Barang!!',
            ]);

            $kode_pembelian = 'PB' . Str::random(8);

            $pembelianData = [
                'nama' => $request->input('nama'),
                'kode_pembelian' => $kode_pembelian,
                'jumlah' => $request->input('jumlah'),
                'harga' => $request->input('harga'),
                'tanggal' => $request->input('tanggal'),
            ];

            $pembelian = Pembelian::create($pembelianData);

            $detailPembelian = Session::get('detailPembelian', []);

            foreach ($detailPembelian as $item) {
                $today = date('Y-m-d');
                $barang = Barang::findOrFail($item['barang_id']);
                $barang->stok += $item['jumlah'];
                $barang->save();

                $barang->update([
                    'harga' => $item['harga'],
                ]);

                DetailPembelian::create([
                    'nama' => $item['nama'],
                    'kode_barang' => $item['kode_barang'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                    'pembelian_id' => $pembelian->id,
                ]);

                history::create([
                    'tanggal' => $today,
                    'keterangan' => 'Pembelian Barang',
                ]);

                KartuStok::create([
                    'tanggal' => $pembelian->tanggal,
                    'barang_id' => $item['barang_id'],
                    'keterangan' => 'Pembelian Barang',
                    'masuk' => $item['jumlah'],
                    'keluar' => 0,
                    'jumlah' => $barang->stok,
                ]);
            }
            Session::forget('detailPembelian');
            return redirect()->back()->with('success', 'Pembelian Sukses');
        } elseif ($request->input('action') == 'batal') {
            Session::forget('detailPembelian');
            return redirect('/pembelian');
        }
    }

    public function jumlah(Request $request){
        $barangId = $request->input('barang_id');
        $hargaBaru = $request->input('harga');
        $today = date('Y-m-d');
        $barang = barang::findOrFail($barangId);
        $detailPembelian = collect(Session::get('detailPembelian', []));
        $detailPembelian = $detailPembelian->map(function ($item) use ($barangId, $hargaBaru) {
            if ($item['barang_id'] == $barangId) {
                $item['harga'] = $hargaBaru;
            }
            return $item;
        });

        Session::put('detailPembelian', $detailPembelian->toArray());

        history::create([
            'tanggal' => $today,
            'keterangan' => 'Update Barang',
        ]);

        return redirect()->back();
    }
}
