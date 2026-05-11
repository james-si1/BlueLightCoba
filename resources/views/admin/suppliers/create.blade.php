@extends('admin.layout')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Supplier</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.suppliers.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Supplier</label>
                <input type="text" name="nama_supplier" class="form-control" value="{{ old('nama_supplier') }}">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>No Telp</label>
                <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="4">{{ old('alamat') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection