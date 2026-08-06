@extends('layouts.app') 

@section('title', 'Produk') 

@section('content') 
@include('layouts.navbar') 

<div class="container-fluid mt-4"> 
    {{-- Alert --}} 
    @if(session('success')) 
        <div class="alert alert-success alert-dismissible fade show shadow-sm"> 
            <i class="bi bi-check-circle"></i> {{ session('success') }} 
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button> 
        </div> 
    @endif 
    @if(session('error')) 
        <div class="alert alert-danger alert-dismissible fade show shadow-sm"> 
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }} 
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button> 
        </div> 
    @endif 

    {{-- Header --}} 
    <div class="d-flex justify-content-between align-items-center mb-4"> 
        <div> 
            <h2 class="fw-bold mb-1"> Data Produk </h2> 
            <p class="text-muted mb-0"> Kelola semua data produk toko </p> 
        </div> 
        @can('create', App\Models\Produk::class) 
            <a href="{{ route('produk.create') }}" class="btn btn-primary px-4"> 
                <i class="bi bi-plus-circle"></i> Tambah Produk 
            </a> 
        @endcan 
    </div> 

    {{-- Card Table --}} 
    <div class="card border-0 shadow-sm"> 
        <div class="card-body"> 
            {{-- Search --}} 
            <form action="{{ route('produk.index') }}" method="GET" class="mb-4"> 
                <div class="row"> 
                    <div class="col-md-5"> 
                        <div class="input-group"> 
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama produk..."> 
                            <button class="btn btn-primary"> 
                                <i class="bi bi-search"></i> Cari 
                            </button> 
                        </div> 
                    </div> 
                </div> 
            </form> 

            {{-- Table --}} 
            <div class="table-responsive"> 
                <table class="table table-hover align-middle"> 
                    <thead class="table-light"> 
                        <tr> 
                            <th>No</th> 
                            <th>Foto</th> 
                            <th>Nama Produk</th> 
                            <th>Pembuat</th> 
                            <th>Harga Beli</th> 
                            <th>Harga Jual</th> 
                            <th>Stok</th> 
                            <th width="180"> Aksi </th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                        @forelse($products as $product) 
                            <tr> 
                                <td> {{ $products->firstItem() + $loop->index }} </td> 
                                <td> 
                                    @if($product->foto) 
                                        <img src="{{ asset('storage/'.$product->foto) }}" class="product-img" alt="{{ $product->nama }}"> 
                                    @else 
                                        <span class="text-muted"> Tidak ada foto </span> 
                                    @endif 
                                </td> 
                                <td> <strong> {{ $product->nama }} </strong> </td> 
                                <td> {{ $product->user->name ?? '-' }} </td> 
                                <td> Rp {{ number_format($product->harga_beli,0,',','.') }} </td> 
                                <td> Rp {{ number_format($product->harga_jual,0,',','.') }} </td> 
                                <td> 
                                    @if($product->stok <= 5) 
                                        <span class="badge bg-danger"> {{ $product->stok }} </span> 
                                    @else 
                                        <span class="badge bg-success"> {{ $product->stok }} </span> 
                                    @endif 
                                </td> 
                                <td> 
                                    <div class="d-flex gap-1"> 
                                        {{-- Detail --}} 
                                        <a href="{{ route('produk.show', $product->id) }}" class="btn btn-info btn-sm text-white"> 
                                            <i class="bi bi-eye"></i> 
                                        </a> 
                                        
                                        {{-- Edit --}}
                                        @can('update',$product) 
                                            <a href="{{ route('produk.edit', $product->id) }}" class="btn btn-warning btn-sm"> 
                                                <i class="bi bi-pencil"></i> 
                                            </a> 
                                        @endcan 
                                        
                                        {{-- Delete --}}
                                        @can('delete',$product) 
                                            <form action="{{ route('produk.destroy', $product->id) }}" method="POST"> 
                                                @csrf 
                                                @method('DELETE') 
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')"> 
                                                    <i class="bi bi-trash"></i> 
                                                </button> 
                                            </form> 
                                        @endcan 
                                    </div> 
                                </td> 
                            </tr> 
                        @empty 
                            <tr> 
                                <td colspan="8" class="text-center py-5 text-muted"> 
                                    <i class="bi bi-box fs-1"></i> <br> 
                                    Data produk belum tersedia 
                                </td> 
                            </tr> 
                        @endforelse 
                    </tbody> 
                </table> 
            </div> 
            <div class="mt-3"> 
                {{ $products->links() }} 
            </div> 
        </div> 
    </div> 
</div> 

<style> 
    body{ background:#f8fafc; } 
    .card{ border-radius:18px; } 
    .table{ border-radius:12px; overflow:hidden; } 
    .table th{ color:#475569; font-weight:600; } 
    .product-img{ width:65px; height:65px; object-fit:cover; border-radius:12px; } 
    .btn{ border-radius:10px; } 
    .badge{ padding:8px 12px; border-radius:10px; } 
</style> 
@endsection
