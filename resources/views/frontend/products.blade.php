@extends('frontend.layout')

@section('content')
<style>
    .content {
        padding: 0 !important;
    }

    .product-page {
        background: linear-gradient(rgba(0, 28, 45, 0.35), rgba(0, 28, 45, 0.45)),
        url("{{ asset('frontend/img/bgberanda.png') }}") top center / cover no-repeat;
        min-height: 1700px;
        color: white;
        padding: 45px 90px 80px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 35px;
    }

    .back-link i {
        width: 42px;
        height: 42px;
        background: rgba(255, 255, 255, 0.55);
        border-radius: 50%;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .category-filter {
        display: flex;
        justify-content: center;
        gap: 25px;
        margin-bottom: 45px;
    }

    .category-filter a {
        text-decoration: none;
        color: white;
        background: #1d3557;
        padding: 12px 30px;
        border-radius: 28px;
        font-weight: 600;
    }

    .category-filter a.active {
        background: white;
        color: #1d3557;
    }

    .section-title {
        font-size: 34px;
        margin: 45px 0 30px;
        font-weight: 800;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
        margin-bottom: 45px;
    }

    .product-card {
        background: rgba(0, 132, 168, 0.72);
        border: 1px solid rgba(255, 255, 255, 0.75);
        border-radius: 14px;
        overflow: hidden;
        min-height: 500px;
        color: white;
        text-decoration: none;
        display: block;
        transition: 0.25s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
    }

    .product-card img {
        width: 100%;
        height: 275px;
        object-fit: cover;
        display: block;
    }

    .product-info {
        padding: 22px 28px;
    }

    .price {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .product-name {
        font-size: 25px;
        line-height: 1.2;
        margin-bottom: 14px;
        font-weight: 600;
    }

    .product-category {
        font-size: 15px;
        color: #eefaff;
        margin-bottom: 25px;
    }

    .buy-btn {
        width: 100%;
        height: 42px;
        border-radius: 25px;
        border: 1px solid white;
        background: transparent;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }

    .see-all {
        display: block;
        width: fit-content;
        margin: 10px auto 70px;
        background: white;
        color: #1d3557;
        padding: 13px 28px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 700;
    }
</style>

<section class="product-page">
    <a href="{{ route('frontend.beranda') }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="category-filter">
        <a href="{{ route('frontend.products.index') }}" class="{{ request('category') == null ? 'active' : '' }}">Semua</a>
        <a href="{{ route('frontend.products.index', ['category' => 'Ikan']) }}" class="{{ request('category') == 'Ikan' ? 'active' : '' }}">Ikan</a>
        <a href="{{ route('frontend.products.index', ['category' => 'Pakan']) }}" class="{{ request('category') == 'Pakan' ? 'active' : '' }}">Pakan Ikan</a>
        <a href="{{ route('frontend.products.index', ['category' => 'Perlengkapan']) }}" class="{{ request('category') == 'Perlengkapan' ? 'active' : '' }}">Perlengkapan</a>
    </div>

    @php
    $groups = $products->groupBy(function($item) {
    return $item->category->nama_kategori ?? 'Lainnya';
    });
    @endphp

    @foreach(['Ikan', 'Pakan', 'Perlengkapan'] as $categoryName)
    @if(isset($groups[$categoryName]) && $groups[$categoryName]->count() > 0)
    <h2 class="section-title">
        {{ $categoryName == 'Pakan' ? 'Pakan Ikan' : $categoryName }}
    </h2>

    <div class="product-grid">
        @foreach((request('category') ? $groups[$categoryName] : $groups[$categoryName]->take(3)) as $p)
        <a href="{{ route('frontend.products.detail', $p->id) }}" class="product-card">
            @if($p->foto)
            <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama_barang }}">
            @else
            <img src="{{ asset('frontend/img/no-image.png') }}" alt="No Image">
            @endif

            <div class="product-info">
                <div class="price">Rp. {{ number_format($p->harga_jual, 0, ',', '.') }}</div>

                <div class="product-name">
                    {{ $p->nama_barang }}
                </div>

                <div class="product-category">
                    {{ $categoryName == 'Pakan' ? 'Pakan Ikan' : $categoryName }}
                </div>

                <button type="button" class="buy-btn">Beli Sekarang</button>
            </div>
        </a>
        @endforeach
    </div>

    @if(request('category') == null)
    <a href="{{ route('frontend.products.index', ['category' => $categoryName]) }}" class="see-all">
        Lihat Semua <i class="fas fa-chevron-right"></i>
    </a>
    @endif
    @endif
    @endforeach
</section>
@endsection