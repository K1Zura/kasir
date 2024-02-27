@extends('template.app')
@section('content')
@section('title', 'Tambah')
<h1 style="font-family: 'Times New Roman', Times, serif">Tambah Produk</h1>
<br>
<div class="card-body">
    <div class="card">
      <div class="card-body">
        <form action="/pembelian-barang" method="POST">
            @csrf
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Kode Produk</label>
            <input type="text" placeholder="Masukkam Kode..." class="form-control" name="kode_barang" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Nama</label>
            <input type="text" placeholder="Masukkan Nama Produk..." name="nama" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3" hidden>
            <label for="exampleInputPassword1" class="form-label">Stok</label>
            <input type="number" placeholder="Masukkan Stok..." value="0" name="stok" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Harga</label>
            <input type="number" placeholder="Masukkan Harga..." name="harga" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Tanggal</label>
            <input type="date" placeholder="Masukkan Harga..." name="tanggal" class="form-control" id="exampleInputPassword1">
          </div>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
      </div>
    </div>
</div>

@endsection
