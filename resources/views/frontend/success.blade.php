@extends('frontend.layout')

@section('content')
<style>
    .content {
        padding: 0 !important;
    }

    .success-page {
        min-height: calc(100vh - 75px);
        background: linear-gradient(rgba(0, 28, 45, 0.35), rgba(0, 28, 45, 0.45)),
        url("{{ asset('frontend/img/bgberanda.png') }}") top center / cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        padding: 40px 20px;
    }

    .success-card {
        width: 520px;
        max-width: 95%;
        background: rgba(0, 132, 168, 0.88);
        border-radius: 20px;
        padding: 45px 38px;
        text-align: center;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.35);
    }

    .success-icon {
        width: 95px;
        height: 95px;
        margin: 0 auto 22px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(255, 255, 255, 0.7);
    }

    .success-icon i {
        font-size: 48px;
        color: #ffffff;
    }

    .success-card h1 {
        font-size: 34px;
        margin-bottom: 15px;
        font-weight: 800;
    }

    .success-card p {
        font-size: 17px;
        line-height: 1.5;
        margin-bottom: 32px;
    }

    .btn-group {
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .btn-success-page {
        text-decoration: none;
        padding: 13px 22px;
        border-radius: 28px;
        font-weight: 700;
        font-size: 15px;
        transition: 0.25s;
    }

    .btn-primary-custom {
        background: #1d3557;
        color: white;
    }

    .btn-outline-custom {
        border: 1.5px solid white;
        color: white;
        background: transparent;
    }

    .btn-success-page:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.25);
    }
</style>

<section class="success-page">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>Pesanan Berhasil</h1>

        <p>
            Pesanan kamu berhasil dibuat dan sedang menunggu proses verifikasi admin.
            Silakan cek riwayat pesanan untuk melihat status pesanan kamu.
        </p>

        <div class="btn-group">
            <a href="{{ route('frontend.products.index') }}" class="btn-success-page btn-outline-custom">
                Kembali Belanja
            </a>

            <a href="{{ route('my.orders') }}" class="btn-success-page btn-primary-custom">
                Lihat Pesanan Saya
            </a>
        </div>
    </div>
</section>
@endsection