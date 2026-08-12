<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Isi title yang kita kirimkan dari views lain -->
    <title>@yield('title')</title>
    <!-- Memanggil asset Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    {{-- 1. PANGGIL NAVBAR DI SINI (Jika navbar Anda dipisah ke file lain, misalnya 'partials.navbar') --}}
    {{-- @include('partials.navbar') --}}

    {{-- 2. PERBAIKAN: Mengubah 'container' menjadi 'container-fluid' agar layar penuh, --}}
    {{-- dan menambahkan 'pt-5 mt-5' agar tabel TURUN ke bawah dan tidak ketimpa --}}
    <div class="container-fluid px-4 pt-5 mt-5">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Isi konten yang kita kirimkan dari views lain -->
        <main class="py-3">
            @yield('content')
        </main>
        
    </div>

</body>
</html>
