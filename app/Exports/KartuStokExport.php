<?php

namespace App\Exports;

use App\Models\barang;
use App\Models\KartuStok;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KartuStokExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tanggal_mulai;
    protected $tanggal_selesai;
    protected $nama_barang;

    public function __construct($tanggal_mulai, $tanggal_selesai, $nama_barang)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
        $this->nama_barang = $nama_barang;
    }

    public function collection()
    {
        $barangId = barang::where('nama', $this->nama_barang)->pluck('id')->first();

        return KartuStok::select(
                'kartu_stoks.tanggal',
                'barangs.nama',
                'kartu_stoks.keterangan',
                'kartu_stoks.masuk',
                'kartu_stoks.keluar',
                'kartu_stoks.jumlah'
            )
            ->leftJoin('barangs', 'kartu_stoks.barang_id', '=', 'barangs.id')
            ->where('kartu_stoks.barang_id', $barangId)
            ->whereBetween('kartu_stoks.tanggal', [$this->tanggal_mulai, $this->tanggal_selesai])
            ->get();
    }

    public function headings(): array
    {
        return ["No", "Tanggal", "Nama Barang", "Keterangan", "Masuk", "Keluar", "Jumlah"];
    }

    /**
     * @param mixed $kartuStok
     * @return array
     */
    public function map($kartuStok): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $kartuStok->tanggal,
            $kartuStok->nama,
            $kartuStok->keterangan,
            $kartuStok->masuk,
            $kartuStok->keluar,
            $kartuStok->jumlah,
        ];
    }
}
