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
    <h1 style="font-family: 'Times New Roman', Times, serif">Laporan Kartu Stok</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Keterangan</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($KartuStok as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->barang->nama }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->masuk }}</td>
                    <td>{{ $item->keluar }}</td>
                    <td>{{ $item->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
