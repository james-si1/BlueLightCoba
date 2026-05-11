@extends('frontend.layout')

@section('content')
<style>
    .content {
        padding: 0 !important;
    }

    .orders-page {
        min-height: calc(100vh - 75px);
        background: linear-gradient(rgba(0, 28, 45, .35), rgba(0, 28, 45, .45)),
        url("{{ asset('frontend/img/bgberanda.png') }}") top center / cover no-repeat;
        color: white;
        padding: 45px 0 80px;
    }

    .orders-container {
        width: 78%;
        max-width: 980px;
        margin: auto;
    }

    .back-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .55);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 22px;
        margin-bottom: 25px;
    }

    .title-box {
        text-align: center;
        margin-bottom: 65px;
    }

    .title-box h1 {
        font-size: 32px;
        margin-bottom: 12px;
    }

    .title-box p {
        font-size: 18px;
        margin: 0;
    }

    .order-card {
        background: rgba(0, 132, 168, .86);
        border-radius: 8px;
        margin-bottom: 16px;
        padding: 20px 25px;
        display: grid;
        grid-template-columns: 60px 1.5fr 1fr 1.1fr 115px;
        align-items: center;
        gap: 18px;
    }

    .order-icon {
        width: 45px;
        height: 45px;
        background: #173653;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .order-name {
        font-size: 18px;
        margin-bottom: 7px;
    }

    .small-info {
        font-size: 13px;
        line-height: 1.6;
    }

    .total-label {
        font-size: 11px;
        font-weight: bold;
        margin-bottom: 6px;
    }

    .total-price {
        font-size: 20px;
        font-weight: bold;
    }

    .status-badge {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 8px;
        color: white;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .status-menunggu {
        background: #ffc107;
        color: #111;
    }

    .status-diproses {
        background: #0d6efd;
    }

    .status-siap {
        background: #20c997;
    }

    .status-selesai {
        background: #6c757d;
    }

    .status-dibatalkan {
        background: #ff1f1f;
    }

    .detail-btn {
        color: white;
        border: 1px solid white;
        border-radius: 6px;
        padding: 8px 13px;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
        text-align: center;
    }

    .detail-btn:hover {
        background: white;
        color: #168bb0;
    }

    .empty {
        background: rgba(0, 132, 168, .86);
        border-radius: 12px;
        padding: 35px;
        text-align: center;
        font-size: 18px;
    }
</style>

<section class="orders-page">
    <div class="orders-container">
        <a href="{{ route('frontend.beranda') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="title-box">
            <h1>Riwayat Pesanan</h1>
            <p>Lihat riwayat dan status pesanan Anda.</p>
        </div>

        @forelse($orders as $order)
        @php
        $total = $order->items->sum(function($item) {
        return $item->jumlah * $item->harga;
        });

        $jumlahProduk = $order->items->sum('jumlah');

        $statusClass = match($order->status) {
        'menunggu' => 'status-menunggu',
        'diproses' => 'status-diproses',
        'siap diambil' => 'status-siap',
        'selesai' => 'status-selesai',
        'dibatalkan' => 'status-dibatalkan',
        default => 'status-menunggu'
        };

        $statusText = match($order->status) {
        'menunggu' => 'Menunggu Verifikasi',
        'diproses' => 'Diproses',
        'siap diambil' => 'Siap Diambil',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
        default => ucfirst($order->status)
        };
        @endphp

        <div class="order-card">
            <div class="order-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>

            <div>
                <div class="order-name">Pesanan #{{ $order->id }}</div>
                <div class="small-info">
                    <i class="fas fa-calendar"></i>
                    {{ $order->created_at->format('d M Y - H.i') }} WIB<br>
                    <i class="fas fa-cube"></i>
                    {{ $jumlahProduk }} Produk
                </div>
            </div>

            <div>
                <div class="total-label">Total Pembayaran</div>
                <div class="total-price">Rp. {{ number_format($total, 0, ',', '.') }}</div>
            </div>

            <div>
                <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                <div class="small-info">
                    Dibayar pada {{ $order->created_at->format('d M Y') }}<br>
                    Metode Pembayaran<br>
                    Transfer
                </div>
            </div>

            <a href="{{ route('my.orders.detail', $order->id) }}" class="detail-btn">
                Lihat Detail →
            </a>
        </div>
        @empty
        <div class="empty">
            Belum ada pesanan.
        </div>
        @endforelse
    </div>
</section>
@endsection