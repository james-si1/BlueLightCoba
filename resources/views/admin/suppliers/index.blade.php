@extends('admin.layout')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Supplier</h1>
    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Supplier
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>Alamat</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $s)
                    <tr>
                        <td>{{ $s->nama_supplier }}</td>
                        <td>{{ $s->email }}</td>
                        <td>{{ $s->no_telp }}</td>
                        <td>{{ $s->alamat }}</td>
                        <td>
                            <a href="{{ route('admin.suppliers.edit', $s->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.suppliers.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus supplier ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data supplier</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection