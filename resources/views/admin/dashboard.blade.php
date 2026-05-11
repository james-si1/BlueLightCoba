@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-primary font-weight-bold">Total Produk</h6>
                    <h3>{{ $totalProduk }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-success font-weight-bold">Total Supplier</h6>
                    <h3>{{ $totalSupplier }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-info font-weight-bold">Total Pesanan</h6>
                    <h3>{{ $totalPesanan }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-warning font-weight-bold">Total Stok Tersedia</h6>
                    <h3>{{ $totalStok }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-danger font-weight-bold">Total Pendapatan</h6>
                    <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection