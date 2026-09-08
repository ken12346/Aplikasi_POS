<nav class="navbar navbar-expand-lg navbar-dark shadow-lg fixed-top" style="background: linear-gradient(135deg,#1e293b,#2563eb);">
    <div class="container-fluid px-4">
        {{-- Logo --}}
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <div class="bg-white text-primary rounded-circle d-flex justify-content-center align-items-center" style="width:38px;height:38px;">
                <i class="bi bi-shop fs-5"></i>
            </div>
            <span>POS SYSTEM MASKEN</span>
        </a>

        {{-- Toggle Mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            {{-- Menu Murni Teks Saja --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ Request::is('dashboard') ? 'active bg-white text-primary fw-bold' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-3 rounded {{ Request::is('admin/users*') ? 'active bg-white text-primary fw-bold' : '' }}" href="{{ route('admin.users.index') }}">
                        Users
                    </a>
                </li>

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

            {{-- Logout Murni Teks Saja --}}
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
