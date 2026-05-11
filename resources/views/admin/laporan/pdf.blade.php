<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        h2,
        h4 {
            margin: 0 0 10px 0;
        }

        .info {
            margin-bottom: 20px;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table,
        th,
        td {
            border: 1px solid #333;
        }

        th {
            background: #eeeeee;
            font-weight: bold;
        }

        th,
        td {
            padding: 6px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .badge-masuk {
            color: #198754;
            font-weight: bold;
        }

        .badge-keluar {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>{{ $judul }}</h2>

    <div class="info">
        <strong>Periode:</strong> {{ $periode }}
    </div>

    <div class="summary">
        <p><strong>Total Pesanan:</strong> {{ $totalPesanan }}</p>
        <p><strong>Total Barang Terjual:</strong> {{ $totalBarang }}</p>
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        <p><strong>Total Keuntungan:</strong> Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</p>
    </div>

    <h4>Detail Transaksi</h4>

    <table>
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
                    @foreach($order->items as $item)
                    - {{ $item->product->nama_barang ?? 'Produk dihapus' }} ({{ $item->jumlah }})<br>
                    @endforeach
                </td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->items->sum('jumlah') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h4>Catatan Stok Keluar Manual / Offline</h4>

    <table>
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
                <td>{{ $log->keterangan ?? 'Offline / Manual' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">Tidak ada catatan stok keluar manual / offline</td>
            </tr>
            @endforelse

            @if(($stockLogs ?? collect())->count() > 0)
            <tr>
                <th colspan="4" style="text-align:right;">Total Offline / Manual</th>
                <th colspan="2">Rp {{ number_format($totalOffline, 0, ',', '.') }}</th>
            </tr>
            @endif
        </tbody>
    </table>

</html>