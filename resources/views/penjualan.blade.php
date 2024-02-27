@extends('template.app')
@section('content')
@section('title', 'Penjualan')
<h1 style="font-family: 'Times New Roman', Times, serif">Penjualan</h1>
<br>
<div class="row">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header">Barang</h5>
            <br>
            <form action="/tambah-barang" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <select class="form-control barang" name="barang_id" id="barang_id" onchange="this.form.submit()">
                        <option value="">...</option>
                        @foreach ($produk as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="jumlah" value="1" hidden>
                </div>
            </form>
            <div class="table-responsive text-nowrap m-3">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($detailPenjualan as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <form action="/update-detail" method="POST" id="FormUpdateDetail">
                                    @csrf
                                    @method('PUT')
                                    <td>
                                        <input type="number" class="form-control jumlah" value="{{ $item['jumlah'] }}" name="jumlah" data-barang-id="{{ $item['barang_id'] }}" size="1">
                                    </td>
                                    <td>{{ number_format($item['harga']) }}</td>
                                    <td>
                                        <input type="hidden" name="barang_id" value="{{ $item['barang_id'] }}">
                                    </form>
                                    <form action="/deleteDetail/{{$item['barang_id']}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger"><i class="ti ti-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <form action="/tambah-penjualan" method="post">
                    @csrf
                    <input class="form-control" placeholder="Kode Transaksi" type="text" name="kode_transaksi" id="" hidden>
                    <input class="form-control" placeholder="Nama Pelanggan" type="text" name="nama_pelanggan" id="">
                    @error('nama_pelanggan')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <?php
                    $totalBayar = 0;
                    foreach($detailPenjualan as $item) {
                        $totalBayar += $item['harga'] * $item['jumlah'];
                    }
                    ?>
                    <input class="form-control" placeholder="Total Bayar" type="number" name="bayar" value="{{ $totalBayar }}" id="total_bayar">
                    @error('bayar')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <input class="form-control" placeholder="Dibayar" type="number" name="dibayar" value="" id="dibayar" oninput="pengurangan()">
                    @error('dibayar')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <input class="form-control" placeholder="Kembalian" type="number" name="kembalian" value="" id="kembalian" readonly>
                    @error('kembalian')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <input type="date" class="form-control" name="tanggal" value="{{date('Y-m-d')}}" id="penjualanTanggal">
                    @error('tanggal')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary" name="action" value="bayar">Bayar</button>
                        <button type="submit" class="btn btn-secondary" name="action" value="batal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
