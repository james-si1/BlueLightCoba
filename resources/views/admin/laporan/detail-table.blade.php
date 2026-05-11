<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi Web / Online</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Total Item</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $order->nama_customer }}</td>
                        <td>
                            <ul class="mb-0 pl-3">
                                @foreach($order->items as $item)
                                <li>
                                    {{ $item->product->nama_barang ?? 'Produk dihapus' }}
                                    ({{ $item->jumlah }})
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->items->sum('jumlah') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data transaksi online</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Catatan Stok Keluar Manual / Offline</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @php $totalOffline = 0; @endphp

                    @forelse($stockLogs ?? [] as $log)
                    @php
                    $harga = $log->product->harga_jual ?? 0;
                    $subtotal = $harga * $log->jumlah;
                    $totalOffline += $subtotal;
                    @endphp

                    <tr>
                        <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y H:i') }}</td>
                        <td>{{ $log->product->nama_barang ?? 'Produk dihapus' }}</td>
                        <td>{{ $log->jumlah }}</td>
                        <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>{{ $log->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada catatan stok keluar manual / offline</td>
                    </tr>
                    @endforelse

                    @if(($stockLogs ?? collect())->count() > 0)
                    <tr>
                        <th colspan="4" class="text-right">Total Offline / Manual</th>
                        <th colspan="2">Rp {{ number_format($totalOffline, 0, ',', '.') }}</th>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>