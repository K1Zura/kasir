<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
</head>
<body>
<div class="container">
    <center>
    <h1>Detail Transaksi</h1>
    <p>Nama Pelanggan: {{ $transaksi->nama_pelanggan }}</p>
    <p>Harga: {{ $transaksi->bayar }}</p>
    <p>Uang: {{ $transaksi->dibayar }}</p>
    <p>Kembalian: {{ $transaksi->kembalian }}</p>
</center>
</div>
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.location.href = "{{ route('laporan') }}";
            }, 1000);
        }
    </script>
</body>
</html>
