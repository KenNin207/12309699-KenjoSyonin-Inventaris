<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Inventaris Wikrama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
            width: 250px;
            transition: all 0.3s;
        }

        .sidebar .nav-link {
            color: #c2c7d0;
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #007bff;
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            width: 100%;
        }

        .topbar {
            background-color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="d-flex">

    <div class="sidebar py-3 px-2 flex-shrink-0">
        <h4 class="text-center fw-bold mb-4 text-white">Inventaris</h4>
        <ul class="nav flex-column">

            @if (Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.*') ? 'bg-primary text-white' : 'text-secondary' }} active}"><i
                            class="bi bi-speedometer2"></i>
                        Dashboard</a>
                </li>

                <li class="nav-item mt-3">
                    <small class="text-muted px-3 text-uppercase" style="font-size: 0.75rem;">Master Data</small>
                </li>
                <a href="{{ route('items.index') }}"
                    class="nav-link {{ request()->routeIs('items.*') ? 'bg-primary text-white' : 'text-secondary' }}">
                    <i class="bi bi-box"></i> Data Barang
                </a>

                <a href="{{ route('categories.index') }}"
                    class="nav-link {{ request()->routeIs('categories.*') ? 'bg-primary text-white' : 'text-secondary' }}">
                    <i class="bi bi-tags"></i> Kategori
                </a>
                <a href="#collapseUsers" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}" aria-controls="collapseUsers"
                    class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('users.*') ? 'bg-primary text-white' : 'text-secondary' }}">

                    <div>
                        <i class="bi bi-people"></i> Accounts
                    </div>
                    <i class="bi bi-chevron-down" style="font-size: 0.8rem;"></i>
                </a>

                <div class="collapse {{ request()->routeIs('users.*') ? 'show' : '' }}" id="collapseUsers">
                    <ul class="nav flex-column ms-4 mt-2" style="list-style-type: disc;">

                        <li class="nav-item mb-2">
                            <a href="{{ route('users.admin') }}"
                                class="nav-link p-0 {{ request()->routeIs('users.admin') ? 'text-warning fw-bold' : 'text-white' }}">
                                Admin
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('users.staff') }}"
                                class="nav-link p-0 {{ request()->routeIs('users.operator') ? 'text-warning fw-bold' : 'text-white' }}">
                                Operator
                            </a>
                        </li>

                    </ul>
                </div>
            @endif

            @if (Auth::user()->role === 'staff')
                <li class="nav-item">
                    <a href="{{ route('staff.dashboard') }}"
                        class="nav-link {{ request()->routeIs('staff.dashboard*') ? 'bg-primary text-white' : 'text-secondary'}}"><i
                            class="bi bi-speedometer2"></i>
                        Dashboard</a>
                </li>
                <li class="nav-item mt-3">
                    <small class="text-muted px-3 text-uppercase" style="font-size: 0.75rem;">Transaksi</small>
                </li>

                <a href="{{ route('staff.items.index') }}"
                    class="nav-link {{ request()->routeIs('staff.items.*') ? 'bg-primary text-white' : 'text-secondary' }}">
                    <i class="bi bi-box"></i> Data Barang
                </a>
                <a href="{{ route('lendings.index') }}"
                    class="nav-link {{ request()->routeIs('lendings.*') ? 'bg-primary text-white' : 'text-secondary' }} }}"><i
                        class="bi bi-cart-plus"></i> Peminjaman
                    Barang</a>
                <a href="{{ route('staff.profile.edit') }}"
                    class="nav-link {{ request()->routeIs('staff.profile.*') ? 'bg-primary text-white' : 'text-secondary' }}"><i
                    class="bi bi-people"></i> Profile
                </a>


            @endif

        </ul>
    </div>

    <div class="main-content">
        <div class="topbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">@yield('header')</h5>
            <div class="d-flex align-items-center">
                <span class="me-3">Halo, <b>{{ Auth::user()->name }}</b> ({{ ucfirst(Auth::user()->role) }})</span>
                <a href="{{ route('logout') }}" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i>
                    Logout</a>
            </div>
        </div>

        <div class="container-fluid p-0">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>