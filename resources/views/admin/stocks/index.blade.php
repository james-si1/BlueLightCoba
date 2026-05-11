@extends('admin.layout')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Manajemen Stok</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th width="320">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $s)
                    <tr>
                        <td>{{ $s->product->nama_barang }}</td>
                        <td>{{ $s->stok }}</td>
                        <td>
                            <form action="{{ route('admin.stocks.update') }}" method="POST" class="d-inline-block">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $s->product_id }}">
                                <input type="hidden" name="tipe" value="masuk">
                                <input type="number" name="jumlah" class="form-control d-inline-block" style="width:100px;" placeholder="Jumlah" required>
                                <button class="btn btn-success btn-sm">Tambah</button>
                            </form>

                            <form action="{{ route('admin.stocks.update') }}" method="POST" class="d-inline-block mt-2 mt-md-0">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $s->product_id }}">
                                <input type="hidden" name="tipe" value="keluar">
                                <input type="number" name="jumlah" class="form-control d-inline-block" style="width:100px;" placeholder="Jumlah" required>
                                <button class="btn btn-danger btn-sm">Kurang</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data stok</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection