<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\barang;
use App\Models\KartuStok;
use Illuminate\Http\Request;
use App\Exports\KartuStokExport;
use Maatwebsite\Excel\Facades\Excel;

class KartuStokController extends Controller
{
    public function kartuStok(Request $request){
        $query = KartuStok::query();
        $barang = Barang::get();
        $today = date('Y-m-d');
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        if (empty($tanggal_mulai) && empty($tanggal_selesai)) {
            $tanggal_mulai = $today;
            $tanggal_selesai = $today;
        }

        if ($request->has('nama_barang')) {
            $query->whereHas('barang', function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->nama_barang.'%');
            });
        }

        $kartuStok = $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
                            ->orderBy('id', 'asc')
                            ->take('10')
                            ->get();

        session()->put('tanggal_mulai', $tanggal_mulai);
        session()->put('tanggal_selesai', $tanggal_selesai);
        session()->put('nama_barang', $request->input('nama_barang'));

        return view('kartu-stok', compact('kartuStok', 'barang'));
    }

    public function Pdf(Request $request){
        $barang = barang::get();
        if ($request->has('nama_barang')) {
            $barang_id = barang::where('nama', $request->nama_barang)->pluck('id')->first();
            $KartuStok = KartuStok::where('barang_id', $barang_id)
                                    ->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai])
                                    ->get();
        } else {
            $KartuStok = KartuStok::whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai])->get();
        }

        if($KartuStok->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        $pdf = PDF::loadView('pdf.kartu_stok', compact('KartuStok', 'barang'));

        return $pdf->stream('kartu_stok.pdf');
    }



    public function Excel(Request $request){
        if ($request->has('nama_barang')) {
            $barang_id = Barang::where('nama', $request->nama_barang)->pluck('id')->first();
            $KartuStok = KartuStok::where('barang_id', $barang_id)
                                    ->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai])
                                    ->get();
        } else {
            $KartuStok = KartuStok::whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai])->get();
        }
        if($KartuStok->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan.');
        }
        return Excel::download(new KartuStokExport($request->tanggal_mulai, $request->tanggal_selesai, $request->nama_barang), 'kartu_stok.xlsx');
    }

}


