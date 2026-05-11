@extends('admin.layout')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Produk</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $product->nama_barang) }}">
            </div>

            <div class="form-group">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control">
                    @foreach($suppliers as $s)
                    <option value="{{ $s->id }}" {{ old('supplier_id', $product->supplier_id) == $s->id ? 'selected' : '' }}>
                        {{ $s->nama_supplier }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control">
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id', $product->category_id) == $c->id ? 'selected' : '' }}>
                        {{ $c->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Harga Modal</label>
                <input type="number" name="harga_modal" class="form-control" value="{{ old('harga_modal', $product->harga_modal) }}">
            </div>

            <div class="form-group">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual', $product->harga_jual) }}">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto Produk</label>
                <input type="file" name="foto" class="form-control-file">
            </div>

            @if($product->foto)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $product->foto) }}" width="120">
            </div>
            @endif

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection