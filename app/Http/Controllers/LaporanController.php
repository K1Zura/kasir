<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\transaksi;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function laporan(Request $request){
        $query = transaksi::query();
        $today = date('Y-m-d');
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        if (empty($tanggal_mulai) && empty($tanggal_selesai)) {
            $tanggal_mulai = $today;
            $tanggal_selesai = $today;
        }

        $laporan = $query->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
                            ->orderBy('id', 'desc')
                            ->take('10')
                            ->get();

        session()->put('tanggal_mulai', $tanggal_mulai);
        session()->put('tanggal_selesai', $tanggal_selesai);

        return view('laporan', compact('laporan'));
    }

    public function Pdf(Request $request){
        $laporan = transaksi::whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai])->get();
        $pdf = PDF::loadView('pdf.transaksi', compact('laporan'));

        if($laporan->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        return $pdf->stream('transaksi.pdf');
    }

    public function Excel(Request $request){
        $laporan = transaksi::whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai])->get();

        if($laporan->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        return Excel::download(new LaporanExport($request->tanggal_mulai, $request->tanggal_selesai), 'transaksi.xlsx');
    }

    public function print($id){
        $transaksi = transaksi::findOrFail($id);
        return view('print.print-ulang-penjualan', compact('transaksi'));
    }
}
