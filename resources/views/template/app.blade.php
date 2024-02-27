<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item {{ Request::is('/') ? 'active' : '' }}">
              <a class="sidebar-link" href="/" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="sidebar-item {{ Request::is('/produk') ? 'active' : '' }}">
                <a class="sidebar-link" href="/produk" aria-expanded="false">
                  <span>
                    <i class="ti ti-shopping-cart"></i>
                  </span>
                  <span class="hide-menu">Produk</span>
                </a>
              </li>
              <li class="sidebar-item {{ Request::is('/pembelian') ? 'active' : '' }}">
                <a class="sidebar-link" href="/pembelian" aria-expanded="false">
                  <span>
                    <i class="ti ti-shopping-cart"></i>
                  </span>
                  <span class="hide-menu">Pembelian</span>
                </a>
              </li>
              <li class="sidebar-item {{ Request::is('/penjualan') ? 'active' : '' }}">
                <a class="sidebar-link" href="/penjualan" aria-expanded="false">
                  <span>
                    <i class="ti ti-shopping-cart"></i>
                  </span>
                  <span class="hide-menu">Penjualan</span>
                </a>
              </li>
              <li class="sidebar-item {{ Request::is('/kartu-stok') ? 'active' : '' }}">
                <a class="sidebar-link" href="/kartu-stok" aria-expanded="false">
                  <span>
                    <i class="ti ti-briefcase"></i>
                  </span>
                  <span class="hide-menu">Kartu Stok</span>
                </a>
              </li>
              <li class="sidebar-item {{ Request::is('/laporan') ? 'active' : '' }}">
                <a class="sidebar-link" href="/laporan" aria-expanded="false">
                  <span>
                    <i class="ti ti-map"></i>
                  </span>
                  <span class="hide-menu">Laporan</span>
                </a>
              </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="/history" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-reload"></i>
                      <p class="mb-0 fs-3">History</p>
                    </a>
                    <a href="/logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        @yield('content')
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
   $(function(){
   $(".barang").select2();
   });
  </script>
  <script>
    function pengurangan() {
        var totalBayar = parseFloat(document.getElementById('total_bayar').value);
        var dibayar = parseFloat(document.getElementById('dibayar').value);
        var kembalian = dibayar - totalBayar;
        document.getElementById('kembalian').value = kembalian;
    }
</script>
<script>
    document.getElementById('jumlah');
    dropdown.addEventListener('change', function() {
        document.getElementById('FormUpdateDetail').submit();
    });
</script>

<script>
    document.querySelectorAll('.numeric-input').forEach(function(element) {
        element.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var kartuStokTable = document.getElementById("kartuStokTable");
        var noDataMessage = document.getElementById("noDataMessage");

        if (kartuStokTable.rows.length <= 1) {
            noDataMessage.style.display = "block";
        } else {
            noDataMessage.style.display = "none";
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var kartuStokTable = document.getElementById("laporanTable");
        var noDataMessage = document.getElementById("noDataLaporan");

        if (kartuStokTable.rows.length <= 1) {
            noDataMessage.style.display = "block";
        } else {
            noDataMessage.style.display = "none";
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tanggal = new Date().toISOString().split('T')[0];
        document.getElementById('penjualanTanggal').setAttribute('max', tanggal);
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tanggal = new Date().toISOString().split('T')[0];
        document.getElementById('pembelianTanggal').setAttribute('max', tanggal);
    });
</script>

<script>
    document.getElementById('filterBtn').addEventListener('click', function() {
        let tanggalMulai = document.getElementById('tanggal_mulai').value;
        let tanggalSelesai = document.getElementById('tanggal_selesai').value;
        let namaBarang = document.getElementById('nama_barang').value;
        if (tanggalMulai === '' || tanggalSelesai === '') {
            alert('Mohon isi kedua tanggal.');
            return;
        }
        window.location.href = `{{ route('kartu-stok') }}?tanggal_mulai=${tanggalMulai}&tanggal_selesai=${tanggalSelesai}&nama_barang=${namaBarang}`;
    });

    document.getElementById('downloadPDF').addEventListener('click', function() {
    let tanggalMulai = document.getElementById('tanggal_mulai').value;
    let tanggalSelesai = document.getElementById('tanggal_selesai').value;
    let namaBarang = document.getElementById('nama_barang').value;
    if (tanggalMulai === '' || tanggalSelesai === '') {
            alert('Mohon isi kedua tanggal.');
            return;
        }
    let url = `{{ route('kartu-stok-pdf') }}?tanggal_mulai=${tanggalMulai}&tanggal_selesai=${tanggalSelesai}&nama_barang=${namaBarang}`;
    window.open(url, '_blank');
    });


    document.getElementById('downloadExcel').addEventListener('click', function() {
        let tanggalMulai = document.getElementById('tanggal_mulai').value;
        let tanggalSelesai = document.getElementById('tanggal_selesai').value;
        let namaBarang = document.getElementById('nama_barang').value;
        if (tanggalMulai === '' || tanggalSelesai === '') {
            alert('Mohon isi kedua tanggal.');
            return;
        }
        window.location.href = `{{ route('kartu-stok-excel') }}?tanggal_mulai=${tanggalMulai}&tanggal_selesai=${tanggalSelesai}&nama_barang=${namaBarang}`;
    });
</script>


<script>
    document.getElementById('laporanBtn').addEventListener('click', function() {
        let tanggalMulai = document.getElementById('tanggal_mulai').value;
        let tanggalSelesai = document.getElementById('tanggal_selesai').value;
        if (tanggalMulai === '' || tanggalSelesai === '') {
            alert('Mohon isi kedua tanggal.');
            return;
        }
        window.location.href = `{{ route('laporan') }}?tanggal_mulai=${tanggalMulai}&tanggal_selesai=${tanggalSelesai}`;
    });

    document.getElementById('laporanPDF').addEventListener('click', function() {
    let tanggalMulai = document.getElementById('tanggal_mulai').value;
    let tanggalSelesai = document.getElementById('tanggal_selesai').value;
    if (tanggalMulai === '' || tanggalSelesai === '') {
            alert('Mohon isi kedua tanggal.');
            return;
        }
    let url = `{{ route('transaksi-pdf') }}?tanggal_mulai=${tanggalMulai}&tanggal_selesai=${tanggalSelesai}`;
    window.open(url, '_blank');
    });


    document.getElementById('laporanExcel').addEventListener('click', function() {
        let tanggalMulai = document.getElementById('tanggal_mulai').value;
        let tanggalSelesai = document.getElementById('tanggal_selesai').value;
        if (tanggalMulai === '' || tanggalSelesai === '') {
            alert('Mohon isi kedua tanggal.');
            return;
        }
        window.location.href = `{{ route('transaksi-excel') }}?tanggal_mulai=${tanggalMulai}&tanggal_selesai=${tanggalSelesai}`;
    });
</script>

@yield('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tanggal = new Date().toISOString().split('T')[0];
        document.getElementById('tanggal_mulai').setAttribute('max', tanggal);
        document.getElementById('tanggal_selesai').setAttribute('max', tanggal);
        document.getElementById('penjualanTanggal').setAttribute('max', tanggal);
    });
</script>
</body>

</html>
