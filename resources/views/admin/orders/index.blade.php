@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Pesanan</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th>Kode Pengambilan</th>
                            <th>Bukti Pembayaran</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>

                            <td>{{ $order->nama_customer }}</td>

                            <td>
                                <ul class="mb-0 pl-3">
                                    @foreach($order->items as $item)
                                    <li>
                                        {{ $item->product->nama_barang ?? 'Produk dihapus' }}
                                        ({{ $item->jumlah }}) - Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                @if($order->status == 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                                @elseif($order->status == 'diproses')
                                <span class="badge badge-primary">Diproses</span>
                                @elseif($order->status == 'siap diambil')
                                <span class="badge badge-info">Siap Diambil</span>
                                @elseif($order->status == 'selesai')
                                <span class="badge badge-success">Selesai</span>
                                @elseif($order->status == 'dibatalkan')
                                <span class="badge badge-danger">Dibatalkan</span>
                                @endif
                            </td>

                            <td>{{ $order->kode_pengambilan ?? '-' }}</td>

                            <td>
                                @if($order->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank">
                                    Lihat Bukti
                                </a>
                                @else
                                -
                                @endif
                            </td>

                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-2">
                                    @csrf
                                    <select name="status" class="form-control mb-2">
                                        <option value="menunggu" {{ $order->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="siap diambil" {{ $order->status == 'siap diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>

                                    <button type="submit" class="btn btn-primary btn-sm btn-block">
                                        Update Status
                                    </button>
                                </form>

                                <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-success btn-sm btn-block mb-2">
                                    <i class="fas fa-print"></i> Print Pesanan
                                </a>

                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm btn-block">
                                        <i class="fas fa-trash"></i> Hapus Pesanan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pesanan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection