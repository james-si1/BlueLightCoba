<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blue Light Aquarium</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: Arial, sans-serif;
            background: #00151f;
        }

        .hero {
            width: 100%;
            height: 100vh;
            background-image: url("{{ asset('frontend/img/hero.png') }}");
            background-size: cover;
            background-position: center;
            position: relative;
            animation: fadeIn 1s ease-in-out;
        }

        .dark-layer {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.15),
                    rgba(0, 0, 0, 0.25));
        }

        .next-btn {
            position: absolute;
            right: 45px;
            bottom: 45px;
            width: 70px;
            height: 70px;
            border-radius: 18px;
            border: 2px solid rgba(255, 255, 255, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 38px;
            color: #ffb000;
            background: rgba(0, 60, 80, 0.45);
            backdrop-filter: blur(8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
            transition: 0.3s ease;
            z-index: 2;
        }

        .next-btn:hover {
            background: rgba(0, 100, 130, 0.65);
            transform: translateX(6px) scale(1.05);
            color: #ffc94a;
        }

        .next-btn span {
            line-height: 1;
            margin-bottom: 4px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(1.02);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .hero {
                background-position: center;
            }

            .next-btn {
                right: 25px;
                bottom: 25px;
                width: 60px;
                height: 60px;
                font-size: 32px;
            }
        }
    </style>
</head>

<body>
    <div class="hero">
        <div class="dark-layer"></div>

        <a href="{{ route('login') }}" class="next-btn">
            <span>→</span>
        </a>
    </div>
</body>

</html>