@extends('frontend.layout')

@section('content')
@php
$user = auth()->user();
@endphp

<style>
    .content {
        padding: 0 !important;
    }

    .checkout-page {
        background: linear-gradient(rgba(0, 28, 45, 0.35), rgba(0, 28, 45, 0.45)),
        url("{{ asset('frontend/img/bgberanda.png') }}") top center / cover no-repeat;
        min-height: calc(100vh - 75px);
        color: white;
        padding: 35px 0 70px;
    }

    .checkout-container {
        width: 88%;
        max-width: 1050px;
        margin: auto;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: white;
        text-decoration: none;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .back-btn i {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.55);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkout-title {
        text-align: center;
        margin-bottom: 45px;
    }

    .checkout-title h1 {
        font-size: 26px;
        margin-bottom: 8px;
    }

    .checkout-title p {
        font-size: 14px;
        margin: 0;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
        align-items: start;
    }

    .box {
        background: rgba(0, 132, 168, 0.85);
        border-radius: 12px;
        padding: 22px;
    }

    .box-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .edit-cart {
        color: white;
        font-size: 13px;
        text-decoration: underline;
    }

    .order-item {
        display: grid;
        grid-template-columns: 70px 1fr auto;
        gap: 14px;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.45);
        padding: 12px 0;
    }

    .order-item img,
    .no-image {
        width: 65px;
        height: 65px;
        border-radius: 7px;
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

    .item-name {
        font-size: 14px;
        margin-bottom: 4px;
    }

    .item-qty {
        font-size: 12px;
    }

    .item-price {
        font-size: 13px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin: 8px 0;
        font-size: 14px;
    }

    .grand-total {
        border-top: 1px solid white;
        padding-top: 12px;
        margin-top: 12px;
        font-size: 20px;
        font-weight: bold;
    }

    .buyer-info {
        margin-top: 18px;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 14px 0;
    }

    .info-row i {
        width: 42px;
        height: 42px;
        background: #173653;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .info-label {
        font-size: 12px;
    }

    .info-value {
        font-size: 17px;
        font-weight: bold;
    }

    .payment-title {
        text-align: center;
        font-size: 18px;
        margin-bottom: 16px;
    }

    .qris-box {
        text-align: center;
        margin-bottom: 25px;
    }

    .qris-box img {
        width: 210px;
        height: 210px;
        object-fit: contain;
        background: white;
        padding: 8px;
    }

    .download-qris {
        display: inline-block;
        color: white;
        font-size: 12px;
        margin-top: 10px;
        text-decoration: none;
    }

    .transfer-title {
        text-align: center;
        border-top: 1px solid rgba(255, 255, 255, 0.45);
        padding-top: 18px;
        margin-bottom: 15px;
        font-size: 14px;
        text-decoration: underline;
    }

    .bank-card {
        border: 1px solid rgba(255, 255, 255, 0.65);
        border-radius: 7px;
        padding: 10px;
        display: grid;
        grid-template-columns: 85px 1fr auto;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .bank-logo {
        width: 70px;
        height: 40px;
        background: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
    }

    .bank-logo img {
        max-width: 55px;
        max-height: 28px;
        object-fit: contain;
    }

    .bank-card {
        transition: 0.3s;
    }

    .bank-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    }

    .copy-btn {
        background: transparent;
        border: 1.5px solid rgba(255, 255, 255, 0.8);
        color: white;
        padding: 6px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        transition: 0.25s;
    }

    .copy-btn:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: white;
        box-shadow: 0 0 8px rgba(255, 255, 255, 0.4);
    }

    .upload-box {
        width: 55%;
        margin: 35px auto 0;
        background: rgba(0, 132, 168, 0.85);
        border-radius: 14px;
        padding: 28px 38px;
    }

    .upload-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .upload-desc {
        font-size: 15px;
        margin-bottom: 25px;
    }

    .upload-area {
        border: 2px dashed white;
        border-radius: 14px;
        padding: 35px 25px;
        text-align: center;
        cursor: pointer;
        display: block;
        transition: 0.3s;
    }

    .upload-area:hover,
    .upload-area.dragover {
        background: rgba(255, 255, 255, 0.12);
    }

    .preview-image {
        max-width: 90%;
        max-height: 230px;
        border-radius: 10px;
        margin: 10px auto;
        object-fit: contain;
        display: block;
    }

    .file-name {
        margin-top: 12px;
        font-size: 14px;
        color: #e8fbff;
    }

    .file-name {
        margin-top: 10px;
        font-size: 13px;
        color: #e8fbff;
    }

    .confirm-area {
        text-align: center;
        margin-top: 35px;
    }

    .confirm-btn {
        background: #168bb0;
        color: white;
        border: none;
        border-radius: 28px;
        padding: 15px 45px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
    }

    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
</style>

<section class="checkout-page">
    <div class="checkout-container">
        <a href="{{ route('cart.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="checkout-title">
            <h1>Checkout</h1>
            <p>Review pesanan Anda dan dapatkan kode pengambilan</p>
        </div>

        @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
        @endif

        @if($errors->any())
        <div class="error-message">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="nama_customer" value="{{ $user->name }}">

            <div class="checkout-grid">
                <div>
                    <div class="box">
                        <div class="summary-header">
                            <div class="box-title">Order Summary</div>
                            <a href="{{ route('cart.index') }}" class="edit-cart">Edit Cart</a>
                        </div>

                        @foreach($cartItems as $item)
                        <div class="order-item">
                            @if(!empty($item['foto']))
                            <img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama_barang'] }}">
                            @else
                            <div class="no-image">No Image</div>
                            @endif

                            <div>
                                <div class="item-name">{{ $item['nama_barang'] }}</div>
                                <div class="item-qty">x{{ $item['jumlah'] }}</div>
                            </div>

                            <div class="item-price">
                                Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach

                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>Rp. {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <div class="total-row grand-total">
                            <span>Total Pembayaran</span>
                            <span>Rp. {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="box buyer-info">
                        <div class="box-title">Informasi Pemesan</div>

                        <div class="info-row">
                            <i class="fas fa-user"></i>
                            <div>
                                <div class="info-label">Nama Pemesan</div>
                                <div class="info-value">{{ $user->name }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <i class="fas fa-phone"></i>
                            <div>
                                <div class="info-label">Nomor Telpon</div>
                                <div class="info-value">{{ $user->no_telp ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="payment-title">Metode Pembayaran</div>

                    <div class="qris-box">
                        <div style="margin-bottom:8px; text-decoration: underline;">QRIS</div>
                        <img src="{{ asset('frontend/img/qris.jpeg') }}" alt="QRIS">
                        <br>
                        <a class="download-qris" href="{{ asset('frontend/img/qris.jpeg') }}" download>
                            <i class="fas fa-download"></i> Unduh QR Code Pembayaran
                        </a>
                    </div>

                    <div class="transfer-title">Transfer</div>

                    <div class="bank-card">
                        <div class="bank-logo">
                            <img src="{{ asset('frontend/img/bca.png') }}" alt="BCA">
                        </div>
                        <div class="bank-info">
                            Bank BCA<br>
                            <span id="bca">1234 5678 9012 3456</span><br>
                            a.n. BlueLight Aquarium
                        </div>
                        <button type="button" class="copy-btn" onclick="copyText('bca')">
                            <i class="fa-regular fa-copy"></i> Salin
                        </button>
                    </div>

                    <div class="bank-card">
                        <div class="bank-logo">
                            <img src="{{ asset('frontend/img/mandiri.png') }}" alt="Mandiri">
                        </div>
                        <div class="bank-info">
                            Bank Mandiri<br>
                            <span id="mandiri">1234 5678 9012 3456</span><br>
                            a.n. BlueLight Aquarium
                        </div>
                        <button type="button" class="copy-btn" onclick="copyText('mandiri')">
                            <i class="fa-regular fa-copy"></i> Salin
                        </button>
                    </div>

                    <div class="bank-card">
                        <div class="bank-logo">
                            <img src="{{ asset('frontend/img/bri.png') }}" alt="BRI">
                        </div>
                        <div class="bank-info">
                            Bank BRI<br>
                            <span id="bri">1234 5678 9012 3456</span><br>
                            a.n. BlueLight Aquarium
                        </div>
                        <button type="button" class="copy-btn" onclick="copyText('bri')">
                            <i class="fa-regular fa-copy"></i> Salin
                        </button>
                    </div>
                </div>
            </div>

            <div class="upload-box">
                <div class="upload-title">Upload Bukti Pembayaran</div>
                <div class="upload-desc">
                    Silakan upload bukti pembayaran Anda untuk mempercepat proses verifikasi pesanan Anda.
                </div>

                <label class="upload-area" id="uploadArea" for="bukti_pembayaran">
                    <div id="uploadContent">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Pilih File / Upload Gambar</p>
                        <p>Format: JPG, PNG, maksimal 2MB</p>
                    </div>

                    <img id="previewImage" class="preview-image" style="display:none;" alt="Preview Bukti Pembayaran">

                    <div class="file-name" id="fileName"></div>
                </label>

                <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*" hidden required>
            </div>

            <div class="confirm-area">
                <button type="submit" class="confirm-btn">Konfirmasi Pemesanan</button>
            </div>
        </form>
    </div>
</section>

<script>
    function copyText(id) {
        const text = document.getElementById(id).innerText;
        navigator.clipboard.writeText(text);
        alert('Nomor rekening berhasil disalin');
    }

    const buktiInput = document.getElementById('bukti_pembayaran');
    const fileName = document.getElementById('fileName');
    const previewImage = document.getElementById('previewImage');
    const uploadContent = document.getElementById('uploadContent');

    buktiInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            fileName.innerText = file.name;

            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';

                // sembunyikan icon + text
                uploadContent.style.display = 'none';
            };

            reader.readAsDataURL(file);
        }
    });

    checkoutForm.addEventListener('submit', function(e) {
        if (!buktiInput.files.length) {
            e.preventDefault();
            alert('Silakan upload bukti pembayaran terlebih dahulu.');
        }
    });
</script>
@endsection