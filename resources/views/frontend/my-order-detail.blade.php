@extends('frontend.layout')

@section('content')
@php
$user = auth()->user();

$total = $order->items->sum(function($item) {
return $item->jumlah * $item->harga;
});

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

<style>
    .content {
        padding: 0 !important;
    }

    .detail-order-page {
        min-height: calc(100vh - 75px);
        background: linear-gradient(rgba(0, 28, 45, .35), rgba(0, 28, 45, .45)),
        url("{{ asset('frontend/img/bgberanda.png') }}") top center / cover no-repeat;
        color: white;
        padding: 45px 0 85px;
    }

    .detail-container {
        width: 88%;
        max-width: 1120px;
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
        margin-bottom: 70px;
    }

    .title-box h1 {
        font-size: 32px;
        margin-bottom: 25px;
    }

    .title-box h3 {
        font-size: 22px;
        margin: 0;
    }

    .detail-card {
        background: rgba(0, 132, 168, .86);
        border-radius: 8px;
        padding: 24px 28px;
    }

    .top-grid {
        display: grid;
        grid-template-columns: 1.6fr 1.1fr 1.5fr;
        gap: 28px;
        align-items: start;
        margin-bottom: 28px;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .status-menunggu {
        background: #ffc107;
        color: #111;
    }

    .status-diproses {
        background: #0d6efd;
        color: white;
    }

    .status-siap {
        background: #20c997;
        color: white;
    }

    .status-selesai {
        background: #6c757d;
        color: white;
    }

    .status-dibatalkan {
        background: #ff1f1f;
        color: white;
    }

    .section-title {
        font-size: 19px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .info-flex {
        display: flex;
        gap: 25px;
        align-items: center;
    }

    .info-row {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 13px;
    }

    .info-row i {
        width: 42px;
        height: 42px;
        background: #173653;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .label {
        font-size: 12px;
    }

    .value {
        font-size: 15px;
        font-weight: bold;
    }

    .middle-border {
        border-left: 1px solid rgba(255, 255, 255, .8);
        padding-left: 28px;
    }

    .location a {
        color: white;
        text-decoration: underline;
        font-size: 13px;
    }

    .bottom-grid {
        display: grid;
        grid-template-columns: 1.2fr 1.1fr 1fr .9fr;
        gap: 24px;
        align-items: start;
    }

    .order-item {
        display: grid;
        grid-template-columns: 70px 1fr;
        gap: 13px;
        align-items: center;
        margin-bottom: 15px;
    }

    .order-item img,
    .no-image {
        width: 65px;
        height: 65px;
        border-radius: 8px;
        object-fit: cover;
    }

    .no-image {
        background: #ddd;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .code-box {
        border: 1.5px dashed white;
        border-radius: 8px;
        padding: 12px;
        font-size: 13px;
        margin-bottom: 25px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .code-box i {
        font-size: 20px;
    }

    .preview-box {
        border: 1.5px dashed white;
        border-radius: 10px;
        padding: 12px;
        text-align: center;
    }

    .preview-box img {
        max-width: 150px;
        height: 210px;
        object-fit: cover;
        border-radius: 5px;
    }

    .note-list {
        margin-top: 90px;
        font-size: 12px;
    }

    .note-row {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
        align-items: flex-start;
    }

    .note-row i {
        color: #b8ffff;
    }

    .payment-text {
        margin-top: 25px;
        font-size: 15px;
    }
</style>

<section class="detail-order-page">
    <div class="detail-container">
        <a href="{{ route('my.orders') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="title-box">
            <h1>Riwayat Pesanan</h1>
            <h3>Daftar pesanan Anda</h3>
        </div>

        <div class="detail-card">
            <div class="top-grid">
                <div>
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>

                    <div class="section-title">Informasi Pemesan</div>

                    <div class="info-flex">
                        <div class="info-row">
                            <i class="fas fa-user"></i>
                            <div>
                                <div class="label">Nama Pemesan</div>
                                <div class="value">{{ $order->nama_customer ?? $user->name }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <i class="fas fa-phone"></i>
                            <div>
                                <div class="label">Nomor Telpon</div>
                                <div class="value">{{ $user->no_telp ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="middle-border">
                    <div class="section-title">Tanggal Pesanan</div>
                    <div class="value">{{ $order->created_at->format('d M Y - H.i') }} WIB</div>

                    <br>

                    <div class="label">Total Pembayaran</div>
                    <div class="value" style="font-size:22px;">Rp. {{ number_format($total, 0, ',', '.') }}</div>
                </div>

                <div class="location">
                    <div class="section-title">
                        <i class="fas fa-location-dot"></i> Lokasi Toko
                    </div>
                    <a href="https://maps.app.goo.gl/BGQFtJAUsZ9TDqU47" target="_blank">
                        https://maps.app.goo.gl/BGQFtJAUsZ9TDqU47
                    </a>
                </div>
            </div>

            <div class="bottom-grid">
                <div>
                    <div class="section-title">Detail Pesanan</div>

                    @foreach($order->items as $item)
                    <div class="order-item">
                        @if($item->product && $item->product->foto)
                        <img src="{{ asset('storage/' . $item->product->foto) }}">
                        @else
                        <div class="no-image">No Image</div>
                        @endif

                        <div>
                            <div>{{ $item->product->nama_barang ?? 'Produk' }}</div>
                            <div>x{{ $item->jumlah }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="middle-border">
                    <div class="section-title">Kode Pengambilan</div>

                    <div class="code-box">
                        <i class="fas fa-lock"></i>
                        <span>
                            @if($order->kode_pengambilan)
                            {{ $order->kode_pengambilan }}
                            @else
                            Kode akan muncul setelah status “siap diambil”
                            @endif
                        </span>
                    </div>

                    <p>
                        Tunjukkan kode pada petugas saat pengambilan
                        (Kode akan aktif setelah verifikasi)
                    </p>
                </div>

                <div>
                    <div class="section-title">Preview Bukti Pembayaran</div>

                    <div class="preview-box">
                        @if($order->bukti_pembayaran)
                        <img src="{{ asset('storage/' . $order->bukti_pembayaran) }}">
                        @else
                        Tidak ada bukti
                        @endif
                    </div>
                </div>

                <div>
                    <div class="note-list">
                        <b>Catatan Penting</b>

                        <div class="note-row">
                            <i class="fas fa-circle-check"></i>
                            <span>Simpan kode ini dengan baik</span>
                        </div>

                        <div class="note-row">
                            <i class="fas fa-circle-check"></i>
                            <span>Tunjukkan kode ke petugas saat pengambilan</span>
                        </div>

                        <div class="note-row">
                            <i class="fas fa-circle-check"></i>
                            <span>Pesanan tidak dapat diambil oleh pihak lain tanpa kode ini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection