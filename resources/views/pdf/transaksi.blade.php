<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid black; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<div class="card-body">
    <h1 style="font-family: 'Times New Roman', Times, serif">Laporan Transaksi</h1>
    <table class="table">
        <thead>
            <tr>
                <th style="text-align: right">No</th>
                <th style="text-align: right">Tanggal</th>
                <th style="text-align: right">Nama</th>
                <th style="text-align: right">Total</th>
                <th style="text-align: right">Dibayar</th>
                <th style="text-align: right">Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $item)
                <tr>
                    <td style="text-align: right">{{ $loop->iteration }}</td>
                    <td style="text-align: right">{{ $item->tanggal }}</td>
                    <td style="text-align: right">{{ $item->nama_pelanggan }}</td>
                    <td style="text-align: right">{{ number_format($item->bayar) }}</td>
                    <td style="text-align: right">{{ number_format($item->dibayar) }}</td>
                    <td style="text-align: right">{{ number_format($item->kembalian) }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="text-align: center" colspan="3"><strong>Jumlah</strong></td>
                <td style="text-align: right"><strong>{{number_format($laporan->sum('bayar'))}}</strong></td>
                <td style="text-align: right"><strong>{{number_format($laporan->sum('dibayar'))}}</strong></td>
                <td style="text-align: right"><strong>{{number_format($laporan->sum('kembalian'))}}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>
