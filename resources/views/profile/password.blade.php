@php
$bgImage = asset('frontend/img/ikan.png');
$logo = asset('frontend/img/blputih1.png');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            color: white;
            background: #10283d;
            overflow: hidden;
        }

        .page {
            width: 100%;
            min-height: 100vh;
            position: relative;
            background: linear-gradient(rgba(13, 38, 58, 0.72), rgba(13, 38, 58, 0.72)),
            url('{{ $bgImage }}') center/cover no-repeat;
            padding-top: 42px;
        }

        .back-btn {
            position: absolute;
            top: 25px;
            left: 25px;
            width: 50px;
            height: 50px;
            border: 2px solid #0d8db7;
            border-radius: 12px;
            color: #2bb9ee;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 24px;
            background: rgba(0, 120, 160, 0.25);
            z-index: 20;
        }

        .logo {
            width: 100%;
            text-align: center;
            margin-bottom: 60px;
        }

        .logo img {
            width: 420px;
            max-width: 80%;
            filter: brightness(1.35) contrast(1.15);
        }

        .card {
            width: 520px;
            margin: auto;
            background: rgba(0, 117, 145, 0.58);
            border-radius: 16px;
            padding: 32px;
            border: 3px solid #0dafff;
        }

        .title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 16px;
        }

        .input-box {
            position: relative;
        }

        .input-box input {
            width: 100%;
            height: 45px;
            border: none;
            border-radius: 6px;
            background: #173653;
            color: white;
            padding: 0 45px 0 40px;
            font-size: 16px;
            outline: none;
        }

        .input-box i.left {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: white;
        }

        .input-box i.right {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            cursor: pointer;
            color: white;
        }

        .btn-area {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            padding: 0 40px;
            gap: 70px;
        }

        .btn-save {
            width: 48%;
            height: 45px;
            border: none;
            border-radius: 6px;
            background: #0b55c8;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-cancel {
            width: 48%;
            height: 45px;
            border: none;
            border-radius: 6px;
            background: #7b8b91;
            color: white;
            text-align: center;
            line-height: 45px;
            text-decoration: none;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="page">

        <a href="{{ route('profile.show') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="logo">
            <img src="{{ $logo }}" alt="Blue Light Aquarium">
        </div>

        <div class="card">
            <div class="title">Change Password</div>

            @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label>Current Password:</label>
                    <div class="input-box">
                        <i class="fa-solid fa-pen left"></i>
                        <input type="password" name="current_password" id="current_password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>New Password:</label>
                    <div class="input-box">
                        <i class="fa-solid fa-lock left"></i>
                        <input type="password" name="password" id="password" required>
                        <i class="fa-solid fa-eye right" onclick="togglePassword('password', this)"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm New Password:</label>
                    <div class="input-box">
                        <i class="fa-solid fa-lock left"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                        <i class="fa-solid fa-eye right" onclick="togglePassword('password_confirmation', this)"></i>
                    </div>
                </div>

                <div class="btn-area">
                    <button type="submit" class="btn-save">Save</button>
                    <a href="{{ route('profile.show') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>

    </div>

    <script>
        function togglePassword(id, icon) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>