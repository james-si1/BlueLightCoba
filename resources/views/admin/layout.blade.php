<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueLight Admin</title>

    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .img-profile {
            width: 42px;
            height: 42px;
            object-fit: cover;
        }

        .topbar-user-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-user-info {
            text-align: right;
            line-height: 1.2;
        }

        .topbar-user-info .name {
            font-weight: 600;
            color: #5a5c69;
        }

        .topbar-user-info .role {
            font-size: 12px;
            color: #858796;
        }

        .logout-btn {
            border: none;
            background: #e74a3b;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #c0392b;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-text mx-3">BlueLight Admin</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Pesanan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.stocks.index') }}">
                    <i class="fas fa-fw fa-warehouse"></i>
                    <span>Stok</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.suppliers.index') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Supplier</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Laporan
            </div>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.laporan.harian') }}">
                    <i class="fas fa-calendar-day"></i>
                    <span>Laporan Harian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.laporan.mingguan') }}">
                    <i class="fas fa-calendar-week"></i>
                    <span>Laporan Mingguan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.laporan.bulanan') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Laporan Bulanan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.laporan.tahunan') }}">
                    <i class="fas fa-calendar"></i>
                    <span>Laporan Tahunan</span>
                </a>
            </li>

            @auth
            @if(auth()->user()->role == 'admin')
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>User</span>
                </a>
            </li>
            @endif
            @endauth

        </ul>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <span class="ml-3 font-weight-bold text-primary">Admin Panel</span>

                    <ul class="navbar-nav ml-auto">
                        @auth
                        <li class="nav-item d-flex align-items-center">
                            <div class="topbar-user-box">
                                <div class="topbar-user-info">
                                    <div class="name">{{ auth()->user()->name }}</div>
                                    <div class="role">
                                        @if(auth()->user()->role == 'admin')
                                        Pemilik / Admin
                                        @elseif(auth()->user()->role == 'pegawai')
                                        Pegawai
                                        @else
                                        Pelanggan
                                        @endif
                                    </div>
                                </div>

                                <img class="img-profile rounded-circle"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4e73df&color=fff"
                                    alt="Profile">

                                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                    @csrf
                                    <button type="submit" class="logout-btn">
                                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                        @endauth
                    </ul>
                </nav>
                <!-- End Topbar -->

                <div class="container-fluid">

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
</body>

</html>