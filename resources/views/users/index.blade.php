@extends('layouts.app')

@section('title', 'Data User')

@section('content')

@include('layouts.navbar')

<div class="container-fluid py-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Data User
            </h3>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Tambah User
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- Search --}}
            <form action="{{ route('admin.users.index') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Cari nama atau email">
                        </div>
                    </div>

                    <div class="col-md-auto">
                        <button class="btn btn-dark">
                            Cari
                        </button>
                    </div>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">
                                No
                            </th>
                            <th>
                                Nama
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Role
                            </th>
                            <th width="150">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2">
                                        {{ strtoupper(substr($user->name,0,1)) }}
                                    </div>
                                    <span>
                                        {{ $user->name }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($user->role->name) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.users.destroy',$user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Data user belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</div>

<style>
    body {
        background: #f5f7fb;
    }

    .card {
        border-radius: 16px;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #0d6efd;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
    }

    .btn {
        border-radius: 8px;
    }
</style>

{{-- Script Otomatis Menghilangkan Kotak Notifikasi Berhasil --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mencari semua elemen alert sukses bawaan bootstrap di halaman ini
        var alerts = document.querySelectorAll('.alert-success, .alert');

        alerts.forEach(function(successAlert) {
            setTimeout(function() {
                // Memberikan efek memudar halus bawaan Bootstrap
                successAlert.classList.remove('show');

                // Menghapus elemen sepenuhnya dari halaman web setelah memudar selesai
                setTimeout(function() {
                    successAlert.remove();
                }, 150);
            }, 3000); // Otomatis hilang dalam waktu 3 detik
        });
    });
</script>

@endsection