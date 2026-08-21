@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
@include('layouts.navbar')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Tombol Kembali --}}
            <div class="mb-3">
                <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
                </a>
            </div>

            {{-- Nota / Struk Card --}}
            <div class="card shadow-sm border-0 invoice-card">
                <div class="card-body p-4 p-md-5">

                    {{-- Header Struk --}}
                    <div class="text-center mb-4 pb-4 border-bottom border-dashed">
                        <h4 class="fw-bold text-uppercase mb-1">POS SYSTEM</h4>
                        <p class="text-muted small mb-0">Detail Struk Transaksi Penjualan</p>
                    </div>

                    {{-- Informasi Transaksi --}}
                    <div class="row g-3 mb-4 text-secondary small">
                        <div class="col-6">
                            <span class="d-block text-muted">ID TRANSAKSI:</span>
                            <strong class="text-dark">#{{ $sale->id }}</strong>
                        </div>
                        <div class="col-6 text-end">
                            <span class="d-block text-muted">TANGGAL:</span>
                            <strong class="text-dark">{{ $sale->created_at->translatedFormat('d F Y H:i') }}</strong>
                        </div>
                        <div class="col-6">
                            <span class="d-block text-muted">NAMA KASIR:</span>
                            <strong class="text-dark">{{ $sale->user->name ?? '-' }}</strong>
                        </div>
                        <div class="col-6 text-end">
                            <span class="d-block text-muted">STATUS:</span>
                            @if($sale->status == 'COMPLETED' || $sale->status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                            @else
                            <span class="badge bg-warning text-dark">{{ ucfirst($sale->status) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Daftar Item Yang Dibeli --}}
                    <div class="table-responsive mb-4">
                        <table class="table align-middle table-borderless">
                            <thead class="table-light">
                                <tr class="text-muted small">
                                    <th>Nama Produk</th>
                                    <th class="text-center">Kuantitas</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sale->itemPenjualan as $item)
                                <tr class="border-bottom border-light">
                                    <td>
                                        <span class="fw-semibold d-block text-dark">{{ $item->produk->nama ?? 'Produk Terhapus' }}</span>
                                        <span class="text-muted small">ID: {{ $item->produk_id }}</span>
                                    </td>
                                    <td class="text-center fw-semibold text-secondary">
                                        {{ $item->kuantitas }}
                                    </td>
                                    <td class="text-end text-secondary">
                                        Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end fw-bold text-dark">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Tidak ada produk dalam transaksi ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Total Akhir --}}
                    <div class="row justify-content-end">
                        <div class="col-md-6">
                            <div class="card bg-light border-0 rounded-3 p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Metode Pembayaran:</span>
                                    <span class="badge bg-primary text-uppercase">{{ $sale->metode_pembayaran }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <span class="fw-bold text-secondary">TOTAL AKHIR:</span>
                                    <span class="h4 fw-extrabold text-success mb-0">
                                        Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    body {
        background: #f8fafc;
    }

    .invoice-card {
        border-radius: 20px;
    }

    .border-dashed {
        border-style: dashed !important;
    }

    .table th {
        font-weight: 600;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
    }

    .btn {
        border-radius: 8px;
    }

    .fw-extrabold {
        font-weight: 800;
    }
</style>
@endsection