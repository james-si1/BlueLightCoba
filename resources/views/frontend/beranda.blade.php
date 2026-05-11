@extends('frontend.layout')

@section('content')
@php
$fishImages = [];

for ($i = 1; $i <= 8; $i++) {
    foreach (['jpeg', 'jpg' , 'png' , 'webp' ] as $ext) {
    $path=public_path("frontend/img/ikan{$i}.{$ext}");

    if (file_exists($path)) {
    $fishImages[]=asset("frontend/img/ikan{$i}.{$ext}");
    break;
    }
    }
    }
    @endphp

    <style>
    .content {
    padding: 0 !important;
    }

    .beranda-page {
    background: linear-gradient(rgba(0, 28, 45, 0.28), rgba(0, 28, 45, 0.35)),
    url("{{ asset('frontend/img/bgberanda.png') }}") top center / cover no-repeat;
    color: white;
    min-height: 1500px;
    }

    .hero-section {
    padding: 175px 0 0 100px;
    }

    .hero-box {
    width: fit-content;
    }

    .hero-title {
    font-size: 38px;
    line-height: 1.2;
    font-weight: 600;
    margin: 0;
    letter-spacing: 0.3px;
    color: #f3f8fb;
    }

    .hero-title span {
    background: linear-gradient(90deg, #00c6ff, #00f2c3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 600;
    }

    .hero-desc {
    width: 560px;
    font-size: 14px;
    line-height: 1.5;
    margin-top: 14px;
    margin-bottom: 25px;
    color: #e4f1f7;
    font-weight: 400;
    }

    .hero-btn {
    display: inline-block;
    background: #09b5df;
    color: white;
    padding: 13px 22px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    margin-top: 4px;
    }

    .fish-slider {
    margin-top: 170px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    }

    .arrow {
    color: white;
    font-size: 42px;
    font-weight: bold;
    margin: 0 25px;
    cursor: pointer;
    user-select: none;
    z-index: 2;
    transition: 0.3s;
    }

    .arrow:hover {
    transform: scale(1.2);
    color: #04d9ff;
    }

    .fish-window {
    width: 680px;
    overflow: hidden;
    }

    .fish-track {
    display: flex;
    gap: 20px;
    transition: transform 0.5s ease;
    }

    .fish-card {
    flex: 0 0 auto;
    width: 155px;
    height: 400px;
    overflow: hidden;
    transform: skew(-5deg);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.45);
    transition: 0.3s;
    }

    .fish-card:hover {
    transform: skew(-5deg) translateY(-10px);
    }

    .fish-card img {
    width: 120%;
    height: 100%;
    object-fit: cover;
    transform: skew(5deg) translateX(-10px);
    }

    .slider-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 25px;
    }

    .dot {
    width: 9px;
    height: 9px;
    background: rgba(255,255,255,0.5);
    border-radius: 50%;
    cursor: pointer;
    transition: 0.3s;
    }

    .dot.active {
    width: 25px;
    border-radius: 20px;
    background: #04d9ff;
    }

    .why-title {
    text-align: center;
    font-size: 26px;
    font-weight: 500;
    margin-top: 100px;
    margin-bottom: 75px;
    }

    .feature-row {
    display: flex;
    justify-content: center;
    gap: 70px;
    padding-bottom: 80px;
    }

    .feature-card {
    width: 250px;
    height: 440px;
    background: rgba(0, 91, 120, 0.55);
    border-radius: 14px;
    text-align: center;
    padding: 70px 35px 35px;
    backdrop-filter: blur(3px);
    transition: 0.3s;
    }

    .feature-card:hover {
    transform: translateY(-10px);
    background: rgba(0, 110, 145, 0.65);
    }

    .feature-card i {
    font-size: 78px;
    margin-bottom: 70px;
    color: white;
    }

    .feature-card h3 {
    font-size: 22px;
    margin-bottom: 65px;
    font-weight: 700;
    }

    .feature-card p {
    font-size: 17px;
    line-height: 1.35;
    color: #eefaff;
    }

    .footer-beranda {
    background: white;
    color: #222;
    padding: 55px 0 95px;
    display: flex;
    justify-content: center;
    gap: 190px;
    font-size: 14px;
    }

    .footer-beranda h4 {
    font-size: 15px;
    margin-bottom: 18px;
    font-weight: 700;
    }

    .footer-beranda p {
    margin: 10px 0;
    }
    </style>

    <section class="beranda-page">
        <div class="hero-section">
            <div class="hero-box">
                <h1 class="hero-title">
                    Pilihan Ikan Hias Terbaik<br>
                    <span>Lengkap dan Berkualitas</span>
                </h1>

                <p class="hero-desc">
                    Jl. Musyawarah No., RT.6/RW.9, Kb. Jeruk, Kec. Kb. Jeruk, Kota Jakarta Barat,
                    Daerah Khusus Ibukota Jakarta 11530
                </p>

                <a href="{{ route('frontend.products.index') }}" class="hero-btn">
                    Lihat Koleksi Produk →
                </a>
            </div>
        </div>

        <div class="fish-slider">
            <div class="arrow" onclick="prevFish()">&lt;</div>

            <div class="fish-window">
                <div class="fish-track" id="fishTrack">
                    @foreach($fishImages as $index => $image)
                    <div class="fish-card">
                        <img src="{{ $image }}" alt="Ikan {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="arrow" onclick="nextFish()">&gt;</div>
        </div>

        <div class="slider-dots" id="sliderDots"></div>

        <h2 class="why-title">Kenapa Memilih Blue Light Aquarium?</h2>

        <div class="feature-row">
            <div class="feature-card">
                <i class="fas fa-crown"></i>
                <h3>Kualitas Terjamin</h3>
                <p>Produk diseleksi ketat dan dipastikan standar kualitas tinggi sebelum dipasarkan</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-handshake"></i>
                <h3>Terpercaya</h3>
                <p>Pelanggan yang puas dengan layanan dan keaslian produk kami</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-users"></i>
                <h3>Konsultasi Gratis</h3>
                <p>Tim ahli kami siap membantu Anda mulai dari setup hingga perawatan harian</p>
            </div>
        </div>
    </section>

    <footer class="footer-beranda">
        <div>
            <h4>Use cases</h4>
            <p>UI design</p>
            <p>UX design</p>
            <p>Wireframing</p>
            <p>Diagramming</p>
            <p>Brainstorming</p>
            <p>Online whiteboard</p>
            <p>Team collaboration</p>
        </div>

        <div>
            <h4>Explore</h4>
            <p>Design</p>
            <p>Prototyping</p>
            <p>Development features</p>
            <p>Design systems</p>
            <p>Collaboration features</p>
            <p>Design process</p>
            <p>FigJam</p>
        </div>

        <div>
            <h4>Resources</h4>
            <p>Blog</p>
            <p>Best practices</p>
            <p>Colors</p>
            <p>Color wheel</p>
            <p>Support</p>
            <p>Developers</p>
            <p>Resource library</p>
        </div>
    </footer>

    <script>
        let currentFishIndex = 0;

        const fishTrack = document.getElementById('fishTrack');
        const fishCards = document.querySelectorAll('.fish-card');
        const sliderDots = document.getElementById('sliderDots');

        const cardWidth = 155;
        const gap = 20;
        const visibleCards = 4;
        const maxIndex = Math.max(fishCards.length - visibleCards, 0);

        function createDots() {
            sliderDots.innerHTML = '';

            for (let i = 0; i <= maxIndex; i++) {
                const dot = document.createElement('div');
                dot.classList.add('dot');

                if (i === currentFishIndex) {
                    dot.classList.add('active');
                }

                dot.addEventListener('click', function() {
                    currentFishIndex = i;
                    updateFishSlider();
                });

                sliderDots.appendChild(dot);
            }
        }

        function updateFishSlider() {
            fishTrack.style.transform = `translateX(-${currentFishIndex * (cardWidth + gap)}px)`;

            document.querySelectorAll('.dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentFishIndex);
            });
        }

        function nextFish() {
            currentFishIndex = currentFishIndex < maxIndex ? currentFishIndex + 1 : 0;
            updateFishSlider();
        }

        function prevFish() {
            currentFishIndex = currentFishIndex > 0 ? currentFishIndex - 1 : maxIndex;
            updateFishSlider();
        }

        createDots();

        setInterval(function() {
            nextFish();
        }, 3500);
    </script>
    @endsection