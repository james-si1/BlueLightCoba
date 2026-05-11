@extends('frontend.layout')

@section('content')
<style>
    .content {
        padding: 0 !important;
    }

    .cart-page {
        background: linear-gradient(rgba(0, 28, 45, 0.35), rgba(0, 28, 45, 0.45)),
        url("{{ asset('frontend/img/bgberanda.png') }}") top center / cover no-repeat;
        min-height: calc(100vh - 75px);
        color: white;
        padding: 30px 0 40px;
    }

    .cart-container {
        width: 84%;
        max-width: 1100px;
        margin: 0 auto;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.55);
        color: white;
        text-decoration: none;
        font-size: 22px;
        margin-bottom: 5px;
    }

    .cart-title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 25px;
        font-weight: 700;
    }

    .select-all {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 22px;
        margin-bottom: 18px;
    }

    .check-box {
        width: 22px;
        height: 22px;
        accent-color: #168bb0;
        cursor: pointer;
    }

    .cart-item {
        position: relative;
        background: rgba(0, 132, 168, 0.85);
        border-radius: 14px;
        padding: 35px 35px;
        margin-bottom: 30px;
        display: grid;
        grid-template-columns: 35px 160px 1fr 130px;
        align-items: center;
        gap: 25px;
        transition: 0.35s ease;
    }

    .cart-item.fade-out {
        opacity: 0;
        transform: translateX(-35px);
    }

    .cart-image img,
    .no-image {
        width: 140px;
        height: 110px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 4px 5px 0 rgba(0, 0, 0, 0.45);
    }

    .no-image {
        background: #ddd;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-name {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .qty-box {
        display: flex;
        width: 130px;
        height: 36px;
        border-radius: 22px;
        overflow: hidden;
        background: #173653;
    }

    .qty-box form {
        width: 33.33%;
        margin: 0;
    }

    .qty-btn {
        width: 100%;
        height: 36px;
        border: none;
        background: #173653;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }

    .qty-number {
        width: 33.33%;
        height: 36px;
        background: #e8e8e8;
        color: black;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .cart-price {
        align-self: end;
        justify-self: end;
        font-size: 18px;
        margin-bottom: 4px;
    }

    .delete-form {
        position: absolute;
        top: 18px;
        right: 22px;
        margin: 0;
    }

    .delete-btn {
        border: none;
        background: transparent;
        color: #ff002b;
        font-size: 20px;
        cursor: pointer;
        transition: 0.25s ease;
    }

    .delete-btn:hover {
        color: #ff3358;
        text-shadow: 0 0 8px #ff002b, 0 0 18px #ff002b;
        transform: scale(1.18);
    }

    .summary-box {
        background: rgba(0, 132, 168, 0.82);
        border-radius: 14px;
        padding: 28px 35px 35px;
        margin-top: 20px;
    }

    .summary-title {
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 22px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 20px;
        margin: 10px 0;
    }

    .summary-line {
        border-top: 2px solid white;
        margin: 15px 0;
    }

    .summary-total {
        font-weight: 800;
    }

    .checkout-area {
        text-align: center;
        margin-top: 35px;
    }

    .checkout-btn {
        background: #168bb0;
        color: white;
        padding: 14px 45px;
        border-radius: 35px;
        border: none;
        font-size: 22px;
        font-weight: 600;
        cursor: pointer;
    }

    .empty {
        background: rgba(0, 132, 168, 0.82);
        padding: 45px;
        border-radius: 14px;
        text-align: center;
        font-size: 22px;
    }

    .empty a {
        color: white;
        font-weight: bold;
    }

    .message-success,
    .message-error {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .message-success {
        background: #d4edda;
        color: #155724;
    }

    .message-error {
        background: #f8d7da;
        color: #721c24;
    }
</style>

<section class="cart-page">
    <div class="cart-container">
        <a href="{{ route('frontend.products.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>

        <h1 class="cart-title">Keranjang Belanja Anda</h1>

        @if(session('success'))
        <div class="message-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="message-error">{{ session('error') }}</div>
        @endif

        @if(empty($cartItems))
        <div class="empty">
            <p>Keranjang masih kosong.</p>
            <a href="{{ route('frontend.products.index') }}">Kembali Belanja</a>
        </div>
        @else
        <form id="checkoutForm" action="{{ route('checkout.index') }}" method="GET"></form>

        <div class="select-all">
            <input type="checkbox" id="selectAll" class="check-box">
            <span>Pilih Semua</span>
        </div>

        @foreach($cartItems as $item)
        <div class="cart-item">
            <input
                type="checkbox"
                class="check-box item-check"
                name="selected_items[]"
                value="{{ $item['product_id'] }}"
                data-subtotal="{{ $item['subtotal'] }}"
                form="checkoutForm">

            <div class="cart-image">
                @if(!empty($item['foto']))
                <img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama_barang'] }}">
                @else
                <div class="no-image">No Image</div>
                @endif
            </div>

            <div class="cart-info">
                <div class="cart-name">{{ $item['nama_barang'] }}</div>

                <div class="qty-box">
                    <form action="{{ route('cart.decrease', $item['product_id']) }}" method="POST">
                        @csrf
                        <button type="submit" class="qty-btn">−</button>
                    </form>

                    <div class="qty-number">{{ $item['jumlah'] }}</div>

                    <form action="{{ route('cart.increase', $item['product_id']) }}" method="POST">
                        @csrf
                        <button type="submit" class="qty-btn">+</button>
                    </form>
                </div>
            </div>

            <div class="cart-price">
                Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}
            </div>

            <form
                action="{{ route('cart.remove', $item['product_id']) }}"
                method="POST"
                class="delete-form"
                onsubmit="return deleteWithFade(event, this)">
                @csrf
                <button type="submit" class="delete-btn" title="Hapus">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>
        </div>
        @endforeach

        <div class="summary-box">
            <div class="summary-title">Rangkuman Belanja</div>

            <div class="summary-row">
                <span>Subtotal</span>
                <span id="selectedSubtotal">Rp. 0</span>
            </div>

            <div class="summary-line"></div>

            <div class="summary-row summary-total">
                <span>Total Pembayaran</span>
                <span id="selectedTotal">Rp. 0</span>
            </div>
        </div>

        <div class="checkout-area">
            <button type="submit" class="checkout-btn" form="checkoutForm">
                Lanjut Ke Pembayaran
            </button>
        </div>
        @endif
    </div>
</section>

<script>
    const selectAll = document.getElementById('selectAll');
    const itemChecks = document.querySelectorAll('.item-check');
    const selectedSubtotal = document.getElementById('selectedSubtotal');
    const selectedTotal = document.getElementById('selectedTotal');
    const checkoutForm = document.getElementById('checkoutForm');

    function formatRupiah(number) {
        return 'Rp. ' + new Intl.NumberFormat('id-ID').format(number);
    }

    function updateTotal() {
        let total = 0;

        itemChecks.forEach(check => {
            if (check.checked) {
                total += parseInt(check.dataset.subtotal);
            }
        });

        if (selectedSubtotal) selectedSubtotal.innerText = formatRupiah(total);
        if (selectedTotal) selectedTotal.innerText = formatRupiah(total);

        if (selectAll) {
            selectAll.checked = itemChecks.length > 0 && [...itemChecks].every(check => check.checked);
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            itemChecks.forEach(check => {
                check.checked = this.checked;
            });

            updateTotal();
        });
    }

    itemChecks.forEach(check => {
        check.addEventListener('change', updateTotal);
    });

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            const selected = [...itemChecks].filter(check => check.checked);

            if (selected.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu produk terlebih dahulu.');
            }
        });
    }

    function deleteWithFade(event, form) {
        event.preventDefault();

        if (!confirm('Hapus produk ini dari keranjang?')) {
            return false;
        }

        const item = form.closest('.cart-item');
        item.classList.add('fade-out');

        setTimeout(() => {
            form.submit();
        }, 350);

        return false;
    }
</script>
@endsection