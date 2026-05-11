<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - BlueLight</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
        }

        /* LEFT */
        .left {
            width: 60%;
            background: url("{{ url('frontend/img/ikan.png') }}") no-repeat center;
            background-size: cover;
            position: relative;
            display: flex;
            align-items: center;
            padding: 60px;
            color: white;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .left-content {
            position: relative;
            max-width: 500px;
        }

        .left h1 {
            font-size: 42px;
            font-weight: 600;
        }

        .left p {
            margin-top: 15px;
            font-size: 16px;
        }

        /* RIGHT */
        .right {
            width: 40%;
            background: #117297;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 80%;
            max-width: 350px;
            color: white;
        }

        .logo {
            margin-bottom: 25px;
        }

        .logo img {
            width: 200px;
        }

        h2 {
            margin-bottom: 5px;
        }

        p {
            margin-bottom: 20px;
            font-size: 14px;
            opacity: 0.9;
        }

        /* INPUT */
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #117297;
        }

        input {
            width: 100%;
            padding: 12px 12px 12px 38px;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
        }

        /* BUTTON */
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #1e2a45;
            color: white;
            border: none;
            border-radius: 25px;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #162033;
        }

        .btn-outline {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            border: 1px solid white;
            margin-top: 10px;
            background: transparent;
            color: white;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .btn-outline:hover {
            background: white;
            color: #117297;
        }

        /* RESPONSIVE */
        @media(max-width: 900px) {
            .left {
                display: none;
            }

            .right {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- LEFT -->
    <div class="left">
        <div class="overlay"></div>
        <div class="left-content">
            <h1>Dari Kami untuk Keindahan Akuarium Anda</h1>
            <p>Kami menghadirkan ikan hias pilihan untuk menciptakan suasana yang indah dan menenangkan.</p>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <div class="login-box">

            <!-- LOGO -->
            <div class="logo">
                <img src="{{ url('frontend/img/blputih1.png') }}">
            </div>

            <h2>Login</h2>
            <p>Masuk dan lanjutkan aktivitasmu</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="email" placeholder="Masukkan Email" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                </div>

                <button class="btn-login">Login</button>

                <a href="/register" class="btn-outline">Sign Up</a>

                <a href="{{ route('frontend.beranda') }}" class="btn-outline">
                    Masuk Sebagai Tamu
                </a>

            </form>
        </div>
    </div>

</body>

</html>