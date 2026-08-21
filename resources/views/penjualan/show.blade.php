@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')
@include('layouts.navbar')

<div class="container py-5">
    <div class="row justify-content-center">
        {{-- Mengunci lebar struk agar tidak melebar ke samping --}}
        <div class="col-12 col-md-8 col-lg-5">

            {{-- Tombol Kembali --}}
            <div class="mb-4">
                <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-light border px-3 text-secondary rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                </a>
            </div>

            {{-- Kartu Struk Utama --}}
            <div class="card border-0 shadow-sm receipt-box">
                <div class="card-body p-4 p-sm-5">

                    {{-- Header Struk --}}
                    <div class="text-center pb-4 border-bottom-dashed">
                        <h4 class="fw-bold text-dark mb-1 tracking-wide">POS SYSTEM</h4>
                        <span class="text-muted text-xs">Detail Struk Transaksi Penjualan</span>
                    </div>

                    {{-- Baris Info 1: ID & Tanggal --}}
                    <div class="d-flex justify-content-between align-items-start pt-4 pb-2 text-xs-custom">
                        <div>
                            <span class="text-muted d-block text-uppercase">ID Transaksi</span>
                            <strong class="text-dark">#{{ $sale->id }}</strong>
                        </div>
                        <div class="text-end">
                            <span class="text-muted d-block text-uppercase">Tanggal</span>
                            <strong class="text-dark">{{ $sale->created_at->translatedFormat('d M Y, H:i') }}</strong>
                        </div>
                    </div>

                    {{-- Baris Info 2: Kasir & Status --}}
                    <div class="d-flex justify-content-between align-items-center pb-4 border-bottom-dashed text-xs-custom">
                        <div>
                            <span class="text-muted d-block text-uppercase">Nama Kasir</span>
                            <strong class="text-dark">{{ $sale->user->name ?? '-' }}</strong>
                        </div>
                        <div class="text-end">
                            <span class="text-muted d-block text-uppercase mb-1">Status</span>
                            @if($sale->status == 'COMPLETED' || $sale->status == 'selesai')
                            <span class="badge bg-success rounded-pill px-2.5 py-1">Selesai</span>
                            @else
                            <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1">{{ ucfirst($sale->status) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Bagian Daftar Item Produk --}}
                    <div class="py-4">
                        <div class="d-flex justify-content-between text-muted text-xs-custom fw-bold text-uppercase pb-2 border-bottom">
                            <span class="col-5">Nama Produk</span>
                            <span class="col-2 text-center">Qty</span>
                            <span class="col-5 text-end">Subtotal</span>
                        </div>

                        <div class="pt-2">
                            @forelse($sale->itemPenjualan as $item)
                            <div class="d-flex justify-content-between align-items-center py-2 text-xs-custom">
                                <div class="col-5">
                                    <span class="fw-bold text-dark d-block text-truncate">{{ $item->produk->nama ?? 'Produk Terhapus' }}</span>
                                    <span class="text-muted small">ID: {{ $item->produk_id }}</span>
                                </div>
                                <div class="col-2 text-center text-dark fw-semibold">
                                    {{ $item->kuantitas }}
                                </div>
                                <div class="col-5 text-end text-dark fw-bold">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-3 text-muted small">Tidak ada produk dalam transaksi ini.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Bagian Total Akhir & Metode Pembayaran --}}
                    <div class="pt-3 border-top-dashed">
                        <div class="d-flex justify-content-between align-items-center mb-2 text-xs-custom">
                            <span class="text-muted text-uppercase">Metode Pembayaran</span>
                            <span class="badge bg-primary px-3 py-1.5 fw-bold text-uppercase">{{ $sale->metode_pembayaran }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <div>
                                <span class="fw-bold text-dark text-uppercase tracking-wider text-xs-custom">Total Akhir</span>
                            </div>
                            <div class="text-end">
                                <h3 class="fw-bold text-success mb-0">
                                    Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- CSS Custom untuk Mengunci Tata Letak --}}
<style>
    body {
        background: #f8fafc;
    }

    .receipt-box {
        border-radius: 16px !important;
        background: #ffffff;
    }

    .text-xs-custom {
        font-size: 0.8rem;
    }

    .tracking-wide {
        letter-spacing: 1px;
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }

    .border-bottom-dashed {
        border-bottom: 1px dashed #dee2e6;
    }

    .border-top-dashed {
        border-top: 1px dashed #dee2e6;
    }
</style>
@endsection