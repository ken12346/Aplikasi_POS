@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@include('layouts.navbar')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Data Penjualan
            </h3>
            <p class="text-muted mb-0">
                Riwayat transaksi penjualan
            </p>
        </div>

        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Transaksi Baru
        </a>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- Search --}}
            <form action="{{ route('penjualan.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Cari transaksi...">

                    <button class="btn btn-dark">
                        <i class="bi bi-search"></i>
                        Cari
                    </button>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>
                                {{ $sales->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $sale->created_at->translatedFormat('d F Y H:i') }}
                            </td>

                            <td>
                                <span class="fw-semibold">
                                    {{ $sale->user->name }}
                                </span>
                            </td>

                            <td>
                                <span class="fw-bold">
                                    Rp {{ number_format($sale->total_pembayaran,0,',','.') }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ ucfirst($sale->metode_pembayaran) }}
                                </span>
                            </td>

                            <td>
                                @if($sale->status == 'selesai')
                                <span class="badge bg-success">
                                    Selesai
                                </span>
                                @else
                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($sale->status) }}
                                </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    {{-- Detail (Ikon Mata) --}}
                                    <a href="{{ route('penjualan.show', $sale) }}"
                                        class="btn btn-sm btn-info text-white"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Edit (Ikon Pensil) --}}
                                    <a href="{{ route('penjualan.edit', $sale) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Hapus (Ikon Tempat Sampah) --}}
                                    <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus transaksi ini?')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{ $sales->links() }}

        </div>
    </div>
</div>

<style>
    body {
        background: #f8fafc;
    }

    .card {
        border-radius: 16px;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        color: #475569;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 20px;
    }

    .btn {
        border-radius: 8px;
    }
</style>

{{-- Script Otomatis Menghilangkan Kotak Hijau yang berasal dari Layout Global --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mencari semua elemen alert class bawaan bootstrap di halaman ini
        var alerts = document.querySelectorAll('.alert-success');

        alerts.forEach(function(successAlert) {
            setTimeout(function() {
                // Berikan efek memudar bawaan Bootstrap
                successAlert.classList.remove('show');

                // Hapus elemen sepenuhnya dari halaman web setelah memudar
                setTimeout(function() {
                    successAlert.remove();
                }, 150);
            }, 3000); // 3 detik otomatis hilang
        });
    });
</script>

@endsection