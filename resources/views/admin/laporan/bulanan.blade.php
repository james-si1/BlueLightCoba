@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Penjualan Bulanan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.bulanan') }}">
                <div class="form-row align-items-end">
                    <div class="col-md-4 mb-2">
                        <label>Pilih Bulan</label>
                        <input type="month" name="bulan" class="form-control" value="{{ $bulan }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary btn-block">Terapkan</button>
                    </div>
                    <div class="col-md-2 mb-2">
                        <a href="{{ route('admin.laporan.bulanan.pdf', ['bulan' => $bulan]) }}" class="btn btn-danger btn-block">
                            Download PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('admin.laporan.summary-cards')

    @include('admin.laporan.detail-table')
</div>
@endsection