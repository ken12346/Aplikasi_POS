@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

@include('layouts.navbar')

<div class="container py-5" style="max-width: 650px;">
    
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            
            <div class="mb-4 text-center">
                <h4 class="fw-bold mb-1">Tambah User Baru</h4>
                <p class="text-muted small">Isi data di bawah untuk mendaftarkan akun baru</p>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label text-dark small fw-medium">Nama Lengkap</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" 
                           placeholder="Nama user" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-dark small fw-medium">Alamat Email</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" 
                           placeholder="email@contoh.com" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-dark small fw-medium">Password</label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Ketik password minimal 8 karakter" 
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label text-dark small fw-medium">Role / Akses</label>
                    <select name="role_id" id="role" class="form-select @error('role_id') is-invalid @enderror" required>
                        <option value="" disabled selected>-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-2 pt-2">
                    <div class="col-8">
                        <button type="submit" class="btn btn-primary w-100 fw-medium">
                            Simpan Data
                        </button>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100 fw-medium">
                            Batal
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
    body {
        background: #f4f6f9;
    }

    .card {
        border-radius: 10px;
    }

    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 0.6rem 0.75rem;
        background-color: #fff;
    }

    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn {
        border-radius: 6px;
        padding: 0.6rem 0.75rem;
    }
</style>

@endsection
