@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
    body {
        background-color: #0f172a;
        min-height: 100vh;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        background: #ffffff;
        border-radius: 16px;
        padding: 40px 30px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .logo {
        width: 70px;
        height: 70px;
        background: #2563eb;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 20px auto;
        font-size: 32px;
        color: white;
    }

    .title {
        text-align: center;
        font-weight: 700;
        font-size: 24px;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .subtitle {
        text-align: center;
        color: #64748b;
        margin-bottom: 30px;
        font-size: 14px;
    }

    .form-label {
        color: #334155;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
    }

    .form-control {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a !important;
        height: 45px;
        border-radius: 8px;
    }

    .form-control:focus {
        background: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .btn-login {
        height: 45px;
        border-radius: 8px;
        background: #2563eb;
        border: none;
        font-weight: 600;
        color: white;
    }

    .btn-login:hover {
        background: #1d4ed8;
        color: white;
    }

    .footer {
        text-align: center;
        color: #94a3b8;
        margin-top: 30px;
        font-size: 13px;
    }
</style>

<div class="login-wrapper">

    <div class="login-card">

        <div class="logo">
            <i class="bi bi-shop"></i>
        </div>

        <div class="title">
            POS SYSTEM GYM KK
        </div>

        <div class="subtitle">
            Login untuk mengakses dashboard
        </div>

        @if ($errors->has('email'))
        <div class="alert alert-danger p-2 small mb-3">
            {{ $errors->first('email') }}
        </div>
        @endif

        <form action="{{ route('auth') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="admin@gmail.com"
                    value="{{ old('email') }}"
                    required>
                @error('email')
                <small class="text-danger d-block mt-1">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                    required>
                @error('password')
                <small class="text-danger d-block mt-1">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <button type="submit" class="btn btn-login w-100">
                Masuk
            </button>
        </form>

        <div class="footer">
            &copy; {{ date('Y') }} Aplikasi POS
        </div>

    </div>

</div>

@endsection

{{-- Script Otomatis Menghilangkan Kotak Hijau Sukses Logout --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mencari elemen alert bawaan bootstrap di halaman login
        var alerts = document.querySelectorAll('.alert-success, .alert');

        alerts.forEach(function(successAlert) {
            setTimeout(function() {
                // Memberikan efek memudar halus bawaan Bootstrap
                successAlert.classList.remove('show');

                // Menghapus elemen sepenuhnya dari halaman web setelah memudar
                setTimeout(function() {
                    successAlert.remove();
                }, 150);
            }, 3000); // Kotak hijau akan otomatis hilang setelah 3 detik
        });
    });
</script>