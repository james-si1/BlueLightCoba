@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Penjualan Mingguan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.mingguan') }}">
                <div class="form-row align-items-end">
                    <div class="col-md-4 mb-2">
                        <label>Pilih Minggu</label>
                        <input type="week" name="minggu" class="form-control" value="{{ $minggu }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary btn-block">Terapkan</button>
                    </div>
                    <div class="col-md-2 mb-2">
                        <a href="{{ route('admin.laporan.mingguan.pdf', ['minggu' => $minggu]) }}" class="btn btn-danger btn-block">
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