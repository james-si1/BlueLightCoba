<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Resi Pesanan #{{ $order->id }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Courier New", monospace;
            margin: 0;
            padding: 15px;
            background: #eee;
            color: #000;
        }

        .print-btn {
            display: block;
            margin: 0 auto 12px;
            padding: 8px 15px;
            background: #1f2e4a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .receipt {
            width: 280px;
            margin: 0 auto;
            background: white;
            padding: 12px;
            font-size: 12px;
            line-height: 1.35;
        }

        .center {
            text-align: center;
        }

        .brand {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .small {
            font-size: 11px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin: 2px 0;
        }

        .item {
            margin-bottom: 7px;
        }

        .item-name {
            font-weight: bold;
            word-break: break-word;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 13px;
            margin-top: 5px;
        }

        .kode-box {
            margin-top: 10px;
            border: 1px dashed #000;
            padding: 8px 5px;
            text-align: center;
        }

        .kode-title {
            font-size: 11px;
            font-weight: bold;
        }

        .kode-value {
            font-size: 15px;
            font-weight: bold;
            margin-top: 3px;
            word-break: break-word;
        }

        @media print {
            @page {
                size: 80mm auto;
                margin: 4mm;
            }

            body {
                background: white;
                padding: 0;
            }

            .print-btn {
                display: none;
            }

            .receipt {
                width: 72mm;
                padding: 0;
                margin: 0 auto;
            }
        }
    </style>
</head>

<body>
    <button onclick="window.print()" class="print-btn">Print Resi</button>

    <div class="receipt">
        <div class="center">
            <div class="brand">BLUELIGHT AQUARIUM</div>
            <div class="small">RESI PESANAN</div>
        </div>

        <div class="line"></div>

        <div class="info-row">
            <span>ID</span>
            <span>#{{ $order->id }}</span>
        </div>

        <div class="info-row">
            <span>Tanggal</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="info-row">
            <span>Customer</span>
            <span>{{ $order->nama_customer }}</span>
        </div>

        <div class="info-row">
            <span>Status</span>
            <span>{{ ucfirst($order->status) }}</span>
        </div>

        <div class="line"></div>

        @php $total = 0; @endphp

        @foreach($order->items as $item)
        @php
        $subtotal = $item->jumlah * $item->harga;
        $total += $subtotal;
        @endphp

        <div class="item">
            <div class="item-name">
                {{ $item->product->nama_barang ?? 'Produk dihapus' }}
            </div>

            <div class="item-detail">
                <span>{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
        </div>
        @endforeach

        <div class="line"></div>

        <div class="total-row">
            <span>TOTAL</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        @if($order->kode_pengambilan)
        <div class="kode-box">
            <div class="kode-title">KODE PENGAMBILAN</div>
            <div class="kode-value">{{ $order->kode_pengambilan }}</div>
        </div>
        @endif
    </div>
</body>

</html>