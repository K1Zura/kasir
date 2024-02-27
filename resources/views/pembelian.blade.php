@extends('template.app')
@section('content')
@section('title', 'Pembelian')
<h1 style="font-family: 'Times New Roman', Times, serif">Pembelian</h1>
<br>
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
        <div class="card mb-4">
            <h5 class="card-header">Barang</h5>
            <div class="card-body">
                <form action="/tambah-pembelian" method="POST">
                    @csrf
                    <br>
                    <div class="input-group mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBarang">Tambah</button>
                    </div>
                    <div class="input-group mb-3">
                        <select class="form-control barang" name="barang_id" id="barang_id" onchange="this.form.submit()">
                            <option value="">...</option>
                            @foreach ($produk as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }} | {{$item->kode_barang}}</option>
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
                            @foreach($detailPembelian as $index => $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item['nama']}}</td>
                                    <form action="/update-pembelian" method="post" onchange="this.form.submit">
                                        @method('PUT')
                                        @csrf
                                        <td>
                                            <input type="text" class="form-control jumlah numeric-input" value="{{ $item['jumlah'] }}" name="jumlah" data-barang-id="{{ $item['barang_id'] }}" size="1">
                                        </td>
                                        <input type="hidden" name="barang_id" value="{{ $item['barang_id'] }}">
                                    </form>
                                    <form action="/update-jumlah" method="post" onchange="this.form.submit">
                                        @method('PUT')
                                        @csrf
                                        <td>
                                            <input type="text" class="form-control numeric-input" value="{{ number_format($item['harga'], 0, ',', ',') }}" name="harga" size="4">
                                        </td>
                                        <input type="hidden" name="barang_id" value="{{ $item['barang_id'] }}">
                                    </form>
                                    <td>
                                        <form action="/hapus-pembelian/{{$item['barang_id']}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger" type="submit"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <form action="/pembelian" method="post">
                    @csrf
                    <input class="form-control" placeholder="Kode Pembelian" type="text" name="kode_pembelian" value="" readonly hidden>
                    @error('kode_pembelian')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <input class="form-control" placeholder="Nama Suplier" type="text" name="nama" id="">
                    @error('nama')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <?php
                    $totalJumlah = 0;
                    foreach($detailPembelian as $item) {
                        $totalJumlah += $item['jumlah'];
                    }
                    ?>
                    <?php
                    $totalBayar = 0;
                    foreach($detailPembelian as $item) {
                        $totalBayar += $item['harga'] * $item['jumlah'];
                    }
                    ?>
                    <input class="form-control" placeholder="Jumlah" type="text" value="{{$totalJumlah}}" name="jumlah" id="">
                    @error('jumlah')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <input class="form-control" placeholder="Harga" type="text" value="{{$totalBayar}}" name="harga" id="">
                    @error('harga')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <input class="form-control" type="date" name="tanggal" value="{{date('Y-m-d')}}" id="pembelianTanggal">
                    @error('tanggal')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                    <br>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary" name="action" value="proses">Simpan</button>
                        <button type="submit" class="btn btn-secondary" name="action" value="batal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahBarang" tabindex="-1" aria-labelledby="tambahBarangLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahBarangLabel">Tambah Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/tambah-pembelian" method="post">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Kode Produk</label>
                    <input type="text" placeholder="Masukkam Kode..." class="form-control" name="kode_barang" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Nama</label>
                    <input type="text" placeholder="Masukkan Nama..." name="nama" class="form-control" id="exampleInputPassword1">
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
                    <input type="date" placeholder="Masukkan Harga..." name="tanggal" value="{{date('Y-m-d')}}" class="form-control" id="exampleInputPassword1">
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="action" value="simpanBarang">Simpan</button>
                </div>
            </form>
      </div>
    </div>
  </div>

@endsection
