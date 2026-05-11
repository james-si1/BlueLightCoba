@php
$bgImage = asset('frontend/img/ikan.png');
$logo = asset('frontend/img/blputih1.png');
$user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>

    <!-- 🔥 FIX ICON (CDN, pasti muncul) -->
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

        /* 🔥 BACK BUTTON */
        .back-btn {
            position: absolute;
            top: 25px;
            left: 25px;
            width: 50px;
            height: 50px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            text-decoration: none;
            backdrop-filter: blur(6px);
            transition: 0.25s ease;
            z-index: 10;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.1);
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

        .profile-card {
            width: 74%;
            max-width: 920px;
            min-height: 365px;
            margin: 0 auto;
            background: rgba(0, 117, 145, 0.58);
            border-radius: 16px;
            padding: 34px 42px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .left-profile {
            width: 230px;
            text-align: center;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 14px;
            object-fit: cover;
            display: block;
            margin: 0 auto 16px;
        }

        .side-btn {
            width: 150px;
            min-height: 44px;
            border-radius: 6px;
            border: none;
            background: #173653;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            margin: 12px auto;
            font-size: 15px;
            cursor: pointer;
        }

        .side-btn i {
            font-size: 25px;
        }

        .info {
            flex: 1;
            padding-left: 20px;
        }

        .name {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 23px;
        }

        .info-row i {
            width: 45px;
            font-size: 32px;
        }

        .info-text {
            font-size: 20px;
            line-height: 1.25;
        }

        .edit-profile {
            position: absolute;
            right: 28px;
            bottom: 24px;
            border: 2px solid #168cc7;
            color: white;
            text-decoration: none;
            padding: 8px 23px;
            border-radius: 6px;
            font-size: 16px;
            background: rgba(0, 40, 65, 0.18);
        }
    </style>
</head>

<body>

    <div class="page">

        <!-- 🔥 BACK BUTTON FIX -->
        <a href="{{ route('frontend.beranda') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>

            <!-- fallback kalau icon gagal -->
            <span style="display:none;">←</span>
        </a>

        <div class="logo">
            <img src="{{ $logo }}" alt="Blue Light Aquarium">
        </div>

        <div class="profile-card">
            <div class="left-profile">
                <img
                    class="avatar"
                    src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}">

                <a href="{{ route('profile.password') }}" class="side-btn">
                    <i class="fas fa-key"></i>
                    <span>Ubah<br>Password</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="side-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>

            <div class="info">
                <div class="name">{{ $user->name }}</div>

                <div class="info-row">
                    <i class="fas fa-phone"></i>
                    <div class="info-text">
                        Phone:<br>
                        {{ $user->no_telp ?? '-' }}
                    </div>
                </div>

                <div class="info-row">
                    <i class="fas fa-envelope"></i>
                    <div class="info-text">
                        Email:<br>
                        {{ $user->email }}
                    </div>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="edit-profile">
                Edit Profile
            </a>
        </div>

    </div>

</body>

</html>