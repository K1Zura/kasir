@extends('template.app')
@section('content')
@section('title', 'Kartu Stok')
<h1 style="font-family: 'Times New Roman', Times, serif">Kartu Stok</h1>
<br>
<div class="row">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="col-lg-6">
        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai:</label>
            <hr>
            <input type="date" class="form-control" id="tanggal_mulai" value="{{ session('tanggal_mulai') ?: date('Y-m-d') }}" name="tanggal_mulai" required>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="tanggal_selesai">Tanggal Selesai:</label>
            <hr>
            <input type="date" class="form-control" id="tanggal_selesai" value="{{ session('tanggal_selesai') ?: date('Y-m-d') }}" name="tanggal_selesai" required>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <hr>
            <select class="form-control barang" name="nama_barang" id="nama_barang" required>
                <option value="">Masukkan Barang</option>
                @foreach ($barang as $item)
                    <option value="{{ $item->nama }}" {{ session('nama_barang') == $item->nama ? 'selected' : '' }}>{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<br>
<div class="col-lg-12 margin-tb">
    <div class="pull-right mb-2">
        <button type="button" class="btn btn-primary" id="filterBtn" onclick="showTable()">Tampil</button>
        <a href="javascript:void(0)" class="btn btn-danger" id="downloadPDF">Download PDF</a>
        <a href="javascript:void(0)" class="btn btn-success" id="downloadExcel">Download Excel</a>
    </div>
</div>
<br>
<div class="container">
    <div class="card">
        <table class="table" id="kartuStokTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Keterangan</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kartuStok as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->tanggal}}</td>
                        <td>{{$item->barang->nama}}</td>
                        <td>{{$item->keterangan}}</td>
                        <td>{{$item->masuk}}</td>
                        <td>{{$item->keluar}}</td>
                        <td>{{$item->jumlah}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="noDataMessage" style="display: none;">Tidak ada transaksi.</div>
</div>

@endsection
