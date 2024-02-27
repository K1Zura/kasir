@extends('template.app')
@section('content')
@section('title', 'History')
<h1 style="font-family: 'Times New Roman', Times, serif">History</h1>
<br>
<div class="container">
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->tanggal}}</td>
                        <td>{{$item->keterangan}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
