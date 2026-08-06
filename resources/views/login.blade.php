@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
    body {
        background: #0f172a;
        min-height: 100vh;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-card {
        width: 400px;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(15px);
        border-radius: 25px;
        padding: 35px;
        color: white;
        box-shadow: 0 20px 40px rgba(0,0,0,.3);
        border: 1px solid rgba(255,255,255,.2);
    }


    .logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg,#38bdf8,#2563eb);
        border-radius: 50%;
        display:flex;
        justify-content:center;
        align-items:center;
        margin:auto;
        font-size:40px;
        color:white;
    }


    .title {
        text-align:center;
        margin-top:20px;
        font-weight:700;
        font-size:28px;
    }


    .subtitle {
        text-align:center;
        color:#cbd5e1;
        margin-bottom:30px;
    }


    .form-label {
        color:#e2e8f0;
    }


    .form-control {
        background:rgba(255,255,255,.15);
        border:none;
        color:white;
        height:48px;
        border-radius:12px;
    }


    .form-control::placeholder {
        color:#cbd5e1;
    }


    .form-control:focus {
        background:rgba(255,255,255,.2);
        color:white;
        box-shadow:0 0 0 3px rgba(56,189,248,.3);
    }


    .btn-login {
        height:48px;
        border-radius:12px;
        background:#38bdf8;
        border:none;
        font-weight:bold;
        color:#0f172a;
        transition:.3s;
    }


    .btn-login:hover {
        background:#7dd3fc;
        transform:translateY(-3px);
    }


    .alert {
        border-radius:12px;
    }


    .footer {
        text-align:center;
        color:#94a3b8;
        margin-top:25px;
        font-size:14px;
    }

</style>


<div class="login-wrapper">


    <div class="login-card">


        <div class="logo">
            <i class="bi bi-shop"></i>
        </div>


        <div class="title">
            POS SYSTEM
        </div>


        <div class="subtitle">
            Login untuk mengakses dashboard
        </div>



        @if ($errors->has('email'))

            <div class="alert alert-danger">
                {{ $errors->first('email') }}
            </div>

        @endif



        <form action="{{ route('auth') }}" method="POST">

            @csrf



            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input 
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="admin@gmail.com"
                    value="{{ old('email') }}"
                >

                @error('email')
                    <small class="text-warning">
                        {{ $message }}
                    </small>
                @enderror

            </div>




            <div class="mb-4">

                <label class="form-label">
                    Password
                </label>


                <input 
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                >


                @error('password')
                    <small class="text-warning">
                        {{ $message }}
                    </small>
                @enderror


            </div>




            <button class="btn btn-login w-100">

                <i class="bi bi-box-arrow-in-right"></i>
                Masuk

            </button>


        </form>



        <div class="footer">
            © {{ date('Y') }} Aplikasi POS
        </div>


    </div>


</div>


@endsection