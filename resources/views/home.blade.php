@extends('template.app')
@section('content')
@section('title', 'Home')
<h1 style="font-family: 'Times New Roman', Times, serif">Dashboard</h1>
<br>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan hari ini</h3>
    </div>
    <div class="card-body">
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Penjualan', 'Pembelian'],
            datasets: [{
                label: 'Hari ini',
                data: [
                    {{ $total_pembayaran }},
                    {{ $total_pembelian }}
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
