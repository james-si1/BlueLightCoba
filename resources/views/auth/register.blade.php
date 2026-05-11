@php
$bgImage = asset('frontend/img/ikan.png');
$logo = asset('frontend/img/blputih1.png');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - BlueLight</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            height: 100vh;
            overflow: hidden;
        }

        .page {
            display: flex;
            height: 100vh;
        }

        .left {
            width: 60%;
            position: relative;
            display: flex;
            align-items: center;
            padding: 60px;
            color: white;
            background: url('{{ $bgImage }}') no-repeat center;
            background-size: cover;
        }

        .left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .left-content {
            position: relative;
            z-index: 2;
            max-width: 520px;
        }

        .left-content h1 {
            font-size: 40px;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .left-content p {
            font-size: 15px;
            line-height: 1.5;
        }

        .right {
            width: 40%;
            background: #117297;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
        }

        .register-box {
            width: 100%;
            max-width: 360px;
            color: white;
        }

        .logo {
            margin-bottom: 12px;
        }

        .logo img {
            width: 160px;
        }

        h2 {
            font-size: 30px;
            margin-bottom: 5px;
        }

        .subtitle {
            margin-bottom: 15px;
            font-size: 14px;
            opacity: 0.9;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        .form-input {
            width: 100%;
            height: 48px;
            padding: 0 12px;
            margin-bottom: 12px;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 14px;
        }

        .password-box {
            position: relative;
            margin-bottom: 12px;
        }

        .password-box input {
            width: 100%;
            height: 48px;
            padding: 0 45px 0 12px;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 14px;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
            font-size: 16px;
        }

        .hint {
            font-size: 12px;
            margin-top: -6px;
            margin-bottom: 10px;
            color: #eaf7fb;
            opacity: 0.9;
        }

        .btn-register {
            width: 100%;
            height: 48px;
            background: #1d3557;
            border: none;
            border-radius: 25px;
            color: white;
            cursor: pointer;
            margin-top: 6px;
        }

        .btn-cancel {
            display: block;
            width: 100%;
            height: 46px;
            line-height: 46px;
            border-radius: 25px;
            border: 1px solid #1d3557;
            background: transparent;
            color: #1d3557;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
            font-size: 14px;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 9px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 13px;
        }

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

    <div class="page">
        <div class="left">
            <div class="left-content">
                <h1>Dari Kami untuk Keindahan Akuarium Anda</h1>
                <p>Kami menghadirkan ikan hias pilihan untuk menciptakan suasana yang indah dan menenangkan.</p>
            </div>
        </div>

        <div class="right">
            <div class="register-box">
                <div class="logo">
                    <img src="{{ $logo }}" alt="BlueLight Logo">
                </div>

                <h2>Sign Up</h2>
                <p class="subtitle">Buat akun dan lanjutkan aktivitasmu</p>

                @if($errors->any())
                <div class="error">
                    @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <label>Nama</label>
                    <input class="form-input" type="text" name="name" placeholder="Masukkan Nama" value="{{ old('name') }}" required autofocus>

                    <label>Email</label>
                    <input class="form-input" type="email" name="email" placeholder="Masukkan Email" value="{{ old('email') }}" required>

                    <label>No Telepon</label>
                    <input class="form-input"
                        type="text"
                        name="no_telp"
                        placeholder="Masukkan No Telepon"
                        value="{{ old('no_telp') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        required>
                    <div class="hint">Nomor telepon hanya angka.</div>

                    <label>Password</label>
                    <div class="password-box">
                        <input type="password" name="password" id="password" placeholder="Masukkan Password" required>
                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>

                    <label>Konfirmasi Password</label>
                    <div class="password-box">
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Masukkan Ulang Password" required>
                        <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>

                    <button type="submit" class="btn-register">Sign Up</button>

                    <a href="{{ route('login') }}" class="btn-cancel">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>

</html>