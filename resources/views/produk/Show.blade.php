@extends('layouts.app')

@section('title', 'Detail Produk - ' . $produk->nama)

@section('content')
@include('layouts.navbar')

<div class="container-fluid mt-4">
    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('produk.index') }}" class="btn btn-light px-3 text-secondary fw-medium rounded-3 shadow-sm border">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Produk
        </a>
    </div>

    {{-- Detail Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row g-5">
                {{-- Bagian Visual / Foto Produk --}}
                <div class="col-md-4 text-center text-md-start">
                    <div class="bg-light p-3 rounded-4 border text-center d-flex align-items-center justify-content-center mx-auto" style="width: 100%; max-width: 320px; aspect-ratio: 1/1;">
                        @if($produk->foto)
                            <img src="{{ asset('storage/' . $produk->foto) }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $produk->nama }}" style="max-height: 100%; object-fit: cover;">
                        @else
                            <div class="text-muted py-5">
                                <i class="bi bi-image text-secondary" style="font-size: 4rem;"></i>
                                <p class="small mb-0 mt-2">Tidak ada foto produk</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bagian Informasi Produk --}}
                <div class="col-md-8 d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill mb-2 small fw-semibold">
                            ID Produk: #{{ $produk->id }}
                        </span>
                        
                        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">{{ $produk->nama }}</h2>
                        <p class="text-muted small mb-4">Ditambahkan oleh: <span class="fw-medium text-secondary">{{ $produk->user->name ?? '-' }}</span></p>
                        
                        <hr class="text-black-50 my-4">

                        {{-- Grid Harga & Stok --}}
                        <div class="row g-4 mb-4">
                            <div class="col-sm-4">
                                <div class="p-3 bg-light rounded-3 border-0">
                                    <small class="text-muted d-block mb-1 fw-medium">Harga Beli (Modal)</small>
                                    <span class="fs-5 fw-bold text-secondary">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-3 bg-primary-subtle rounded-3 border-0">
                                    <small class="text-primary-emphasis d-block mb-1 fw-medium">Harga Jual</small>
                                    <span class="fs-5 fw-bold text-primary">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-3 rounded-3 border-0 {{ $produk->stok <= 5 ? 'bg-danger-subtle' : 'bg-success-subtle' }}">
                                    <small class="{{ $produk->stok <= 5 ? 'text-danger-emphasis' : 'text-success-emphasis' }} d-block mb-1 fw-medium">Sisa Stok</small>
                                    <span class="fs-5 fw-bold {{ $produk->stok <= 5 ? 'text-danger' : 'text-success' }}">{{ $produk->stok }} Unit</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi Cepat --}}
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        @can('update', $produk)
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning px-4 py-2 fw-medium rounded-3 shadow-sm">
                                <i class="bi bi-pencil me-1"></i> Edit Data
                            </a>
                        @endcan
                        
                        @can('delete', $produk)
                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger px-4 py-2 fw-medium rounded-3" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background: #f8fafc; }
    .card { border-radius: 18px; }
</style>
@endsection
