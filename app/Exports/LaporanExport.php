<?php

namespace App\Exports;

use App\Models\transaksi;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tanggal_mulai;
    protected $tanggal_selesai;

    public function __construct($tanggal_mulai, $tanggal_selesai)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    public function collection()
    {
        return transaksi::select(
            'transaksis.tanggal',
            'transaksis.nama_pelanggan',
            'transaksis.bayar',
            'transaksis.dibayar',
            'transaksis.kembalian',
        )
        ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai])
        ->get();
    }

    public function headings(): array
    {
        return ["No", 'Tanggal', "Nama", "Total", "Dibayar", "Kembalian"];
    }

    /**
     * @param mixed $laporan
     * @return array
     */
    public function map($laporan): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $laporan->tanggal,
            $laporan->nama_pelanggan,
            $laporan->bayar,
            $laporan->dibayar,
            $laporan->kembalian,
        ];
    }
}
