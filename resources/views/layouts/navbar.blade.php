<nav class="navbar navbar-expand-lg navbar-dark shadow-lg fixed-top" style="background: linear-gradient(135deg,#1e293b,#2563eb);">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('tentang') }}">
            <span>POS SYSTEM GYM KK</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ Request::is('dashboard') ? 'active bg-white text-primary fw-bold' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                @if(auth()->user()->role->name === 'admin')
                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ Request::is('admin/users*') ? 'active bg-white text-primary fw-bold' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        Users
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ Request::is('produk*') ? 'active bg-white text-primary fw-bold' : '' }}" href="{{ route('produk.index') }}">
                        Produk
                    </a>
                </li>
                

                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ Request::is('penjualan*') ? 'active bg-white text-primary fw-bold' : '' }}" href="{{ route('penjualan.index') }}">
                        Penjualan
                    </a>
                </li>
            </ul>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light rounded-pill px-4 fw-semibold">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<style>
    .nav-link {
        transition: .3s;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, .15);
        transform: translateY(-2px);
    }

    .navbar-brand span {
        letter-spacing: 1px;
    }

    .btn-light {
        transition: .3s;
    }

    .btn-light:hover {
        transform: translateY(-2px);
        background: #e0f2fe;
    }
</style>