@extends('template.app')
@section('content')
@section('title', 'Laporan')
<h1 style="font-family: 'Times New Roman', Times, serif">Laporan</h1>
<br>
<div class="row">
    @if (session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
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
</div>
<br>
<div class="col-lg-12 margin-tb">
    <div class="pull-right mb-2">
        <button type="button" class="btn btn-primary" id="laporanBtn">Tampil</button>
        <a href="javascript:void(0)" class="btn btn-danger" id="laporanPDF">Download PDF</a>
        <a href="javascript:void(0)" class="btn btn-success" id="laporanExcel">Download Excel</a>
    </div>
</div>
<br>
<div class="container">
    <div class="card">
        <table class="table" id="laporanTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Total</th>
                    <th>Dibayar</th>
                    <th>Kembalian</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->tanggal}}</td>
                        <td>{{$item->nama_pelanggan}}</td>
                        <td>{{$item->bayar}}</td>
                        <td>{{$item->dibayar}}</td>
                        <td>{{$item->kembalian}}</td>
                        <td>
                            <a href="/print-ulang/{{$item->id}}" class="btn btn-primary">Print Ulang</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="noDataLaporan" style="display: none;">Tidak ada transaksi.</div>
</div>


@endsection
