@extends('admin.layout')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Produk</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
            </div>

            <div class="form-group">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $s)
                    <option value="{{ $s->id }}" {{ old('supplier_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nama_supplier }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Harga Modal</label>
                <input type="number" name="harga_modal" class="form-control" value="{{ old('harga_modal') }}">
            </div>

            <div class="form-group">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto Produk</label>
                <input type="file" name="foto" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection