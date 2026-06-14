@extends('backend.v_layout.app')
@section('content')
<!-- contentAwal -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body border-top">
                <h5 class="card-title"> {{$judul}}</h5>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading"> Selamat Datang, {{ Auth::user()->nama}}</h4>
                    Aplikasi Toko Online dengan hak akses yang anda miliki sebagai
                    <b>
                        @if (Auth::user()->role ==1)
                        Super Admin
                        @elseif(Auth::user()->role ==0)
                        Admin
                        @endif
                    </b>
                    ini adalah halaman utama dari aplikasi Web Programming. Studi Kasus Toko Online.
                    <hr>
                    <p class="mb-0">Kuliah..? BSI Aja !!!</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========================================================================================================= -->
            <div class="row">
                <!-- Column -->
                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover">
                        <div class="box bg-cyan text-center">
                            <h1 class="font-light text-white"></i></h1>
                            <h3 class="text-white">{{DB::table('produk')->count('id');}}</h3>
                            <h6 class="text-white">Produk</h6>
                        </div>
                    </div>
                </div>
            <!-- Column -->
                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover">
                        <div class="box bg-warning text-center">
                            <h1 class="font-light text-white"></h1>
                            <h3 class="text-white">{{ DB::table('produk')->sum('stok') }}</h3>
                            <h6 class="text-white">Total Stok</h6>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover">
                        <div class="box bg-success text-center">
                            <h1 class="font-light text-white"><h1>
                            <h3 class="text-white">{{ DB::table('order')->count('id') }}</h3>
                            <h6 class="text-white">Total Pesanan</h6>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover">
                        <div class="box bg-danger text-center">
                            <h1 class="font-light text-white"></h1>
                            <h3 class="text-white">Rp {{ number_format(DB::table('order')->sum('total_harga'), 0, ',', '.') }}</h3>
                            <h6 class="text-white">Total Pendapatan</h6>
                        </div>
                    </div>
                </div>
            <!-- END MODAL -->

            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">Site Analysis</h4>
                                    <h5 class="card-subtitle">Overview of Latest Month</h5>
                                </div>
                            </div>
                            <div class="row">
                                <!-- column -->
                                <div class="col-lg-9">
                                    <canvas id="myChart"></canvas>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                <!-- column -->
                                <div class="col-6">
                                    <div class="bg-dark p-10 text-white text-center">
                                       <i class="fa fa-user m-b-5 font-16"></i>
                                       <h5 class="m-b-0 m-t-5">{{ DB::table('customer')->count('id') }}</h5>
                                       <small class="font-light">Total Users</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-dark p-10 text-white text-center">
                                       <i class="fa fa-plus m-b-5 font-16"></i>
                                       <h5 class="m-b-0 m-t-5">    {{ DB::table('customer')
                                           ->whereDate('created_at', today())
                                           ->count('id') }}</h5>
                                       <small class="font-light">New Users</small>
                                    </div>
                                </div>
                                <div class="col-6 m-t-15">
                                    <div class="bg-dark p-10 text-white text-center">
                                       <i class="fa fa-cart-plus m-b-5 font-16"></i>
                                       <h5 class="m-b-0 m-t-5"></h5>
                                       <small class="font-light">Total Shop</small>
                                    </div>
                                </div>
                                <div class="col-6 m-t-15">
                                    <div class="bg-dark p-10 text-white text-center">
                                       <i class="fa fa-tag m-b-5 font-16"></i>
                                       <h5 class="m-b-0 m-t-5">{{ DB::table('order')->count('id') }}</h5>
                                       <small class="font-light">Total Orders</small>
                                    </div>
                                </div>
                                <div class="col-6 m-t-15">
                                    <div class="bg-dark p-10 text-white text-center">
                                       <i class="fa fa-table m-b-5 font-16"></i>
                                       <h5 class="m-b-0 m-t-5"></h5>
                                       <small class="font-light">Pending Orders</small>
                                    </div>
                                </div>
                                <div class="col-6 m-t-15">
                                    <div class="bg-dark p-10 text-white text-center">
                                       <i class="fa fa-globe m-b-5 font-16"></i>
                                       <h5 class="m-b-0 m-t-5">8540</h5>
                                       <small class="font-light">Online Orders</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- column -->
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- ============================================================== -->
        <!-- Sales chart -->
        <!-- ============================================================== -->

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('grafik').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($nama_produk),
                    datasets: [{
                        label: 'Jumlah Stok',
                        data: @json($stok_produk),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
        </script>

<!-- contentAkhir -->
@endsection
