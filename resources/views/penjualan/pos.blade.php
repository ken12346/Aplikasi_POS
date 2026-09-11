@extends('layouts.app') 

@section('title', 'POS') 

@section('content') 
@if(session('errors')) 
    <div class="alert alert-danger"> 
        {{ session('errors') }} 
    </div> 
@endif 

<h4 class="mb-3">Tambah dan Edit</h4> 

<div class="row"> 
    {{-- ================= PRODUK ================= --}} 
    <div class="col-md-6"> 
        <div class="card"> 
            <div class="card-body" style="max-height:70vh; overflow:auto"> 
                {{-- Search Produk --}} 
                <div class="mb-3"> 
                    <form method="GET" action="{{ route('penjualan.create') }}"> 
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari produk..." onkeyup="this.form.submit()"> 
                    </form> 
                </div> 

                @foreach($products as $product) 
                    <form method="POST" action="{{ route('itempenjualan.store') }}" class="row mb-2"> 
                        @csrf 
                        <input type="hidden" name="product_id" value="{{ $product->id }}"> 
                        <div class="col-7"> 
                            <button type="submit" class="btn btn-outline-primary w-100 text-start p-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}"> 
                                <div class="d-flex align-items-center gap-2"> 
                                    {{-- Gambar produk --}} 
                                    <img src="{{ asset('storage/'.$product->foto) }}" alt="Gambar" class="rounded-circle" style="width:45px; height:45px; object-fit:cover;"> 
                                    {{-- Nama & harga --}} 
                                    <div> 
                                        <div class="fw-semibold">{{ $product->nama }}</div> 
                                        <small class="text-muted">Rp {{ number_format($product->harga_jual) }}</small> 
                                    </div> 
                                </div> 
                            </button> 
                        </div> 
                        <div class="col-3"> 
                            <input type="number" name="quantity" value="1" min="1" class="form-control {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}"> 
                        </div> 
                        <div class="col-2"> 
                            <button class="btn btn-primary w-100 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">+</button> 
                        </div> 
                    </form> 
                @endforeach 
            </div> 
        </div> 
    </div> 

    {{-- ================= KERANJANG ================= --}} 
    <div class="col-md-6"> 
        <div class="card"> 
            <table class="table table-bordered mb-0"> 
                <thead> 
                    <tr> 
                        <th>Produk</th> 
                        <th>Harga</th> 
                        <th>Qty</th> 
                        <th>Subtotal</th> 
                        <th>Aksi</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    @forelse($sale->itemPenjualan as $item) 
                        <tr> 
                            <td>{{ $item->produk->nama }}</td> 
                            <td>Rp {{ number_format($item->produk->harga_jual) }}</td> 
                            <td> 
                                <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}"> 
                                    @csrf 
                                    @method('PUT') 
                                    <input type="number" name="quantity" value="{{ $item->kuantitas }}" class="form-control form-control-sm" onchange="this.form.submit()"> 
                                </form> 
                            </td> 
                            <td>Rp {{ number_format($item->subtotal) }}</td> 
                            <td> 
                                <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}"> 
                                    @csrf 
                                    @method('DELETE') 
                                    <button class="btn btn-danger btn-sm"> Hapus </button> 
                                </form> 
                            </td> 
                        </tr> 
                    @empty 
                        <tr> 
                            <td colspan="5" class="text-center text-muted"> Belum ada item </td> 
                        </tr> 
                    @endforelse 
                </tbody> 
            </table> 
            
            <div class="card-footer"> 
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span>Total Pembayaran:</span>
                    <strong class="fs-5">Rp {{ number_format($sale->total_pembayaran) }}</strong> 
                </div>

                {{-- Checkout Form --}} 
                <form method="POST" action="{{ route('penjualan.update', $sale->id) }}" onsubmit="return confirm('Yakin ingin checkout?')" class="mt-2"> 
                    @csrf 
                    @method('PUT') 
                    
                    <select name="payment_method" id="payment_method" class="form-select mb-2" required> 
                        <option value="">Pilih Pembayaran</option> 
                        <option value="CASH">Cash</option> 
                        <option value="QRIS">QRIS</option> 
                    </select> 

                    {{-- Bagian Uang Bayar dan Kembalian --}}
                    <div id="cash-payment-section" style="display: none;">
                        <div class="mb-2">
                            <label class="form-label small text-muted mb-1">Uang Tunai / Dibayarkan (Rp)</label>
                            <input type="number" id="cash_received" name="cash_received" class="form-control" placeholder="Masukkan nominal uang...">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                            <span class="small fw-semibold text-secondary">Kembalian:</span>
                            <strong id="change_amount" class="text-success">Rp 0</strong>
                        </div>
                    </div>

                    <button type="submit" id="btn-bayar" class="btn btn-success w-100 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}"> 
                        Bayar 
                    </button> 
                </form> 

                @can('delete', $sale) 
                    <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan transaksi?')"> 
                        @csrf 
                        @method('DELETE') 
                        <button class="btn btn-outline-danger w-100 mt-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}"> 
                            Batalkan Transaksi 
                        </button> 
                    </form> 
                @endcan 
            </div> 
        </div> 
    </div> 
</div> 

{{-- Script Perhitungan Kembalian Otomatis --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethod = document.getElementById('payment_method');
        const cashSection = document.getElementById('cash-payment-section');
        const cashReceived = document.getElementById('cash_received');
        const changeAmount = document.getElementById('change_amount');
        const btnBayar = document.getElementById('btn-bayar');
        
        // Mengambil nilai total pembayaran asli dari backend
        const totalPembayaran = {{ $sale->total_pembayaran ?? 0 }};

        // Event listener saat metode pembayaran diubah
        paymentMethod.addEventListener('change', function () {
            if (this.value === 'CASH') {
                cashSection.style.style = 'display: block';
                cashSection.style.display = 'block';
                cashReceived.setAttribute('required', 'required');
            } else {
                cashSection.style.display = 'none';
                cashReceived.removeAttribute('required');
                cashReceived.value = '';
                changeAmount.innerText = 'Rp 0';
                changeAmount.className = 'text-success';
                btnBayar.removeAttribute('disabled');
            }
        });

        // Event listener saat kasir mengetik nominal uang tunai
        cashReceived.addEventListener('input', function () {
            const uangBayar = parseFloat(this.value) || 0;
            const kembalian = uangBayar - totalPembayaran;

            if (uangBayar === 0) {
                changeAmount.innerText = 'Rp 0';
                changeAmount.className = 'text-success';
                btnBayar.removeAttribute('disabled');
            } else if (kembalian < 0) {
                // Jika uang kurang
                changeAmount.innerText = 'Uang kurang: Rp ' + new Intl.NumberFormat('id-ID').format(Math.abs(kembalian));
                changeAmount.className = 'text-danger fw-bold';
                btnBayar.setAttribute('disabled', 'disabled'); // Kunci tombol bayar jika uang kurang
            } else {
                // Jika uang pas / lebih
                changeAmount.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(kembalian);
                changeAmount.className = 'text-success fw-bold';
                btnBayar.removeAttribute('disabled'); // Buka kunci tombol bayar
            }
        });
    });
</script>
@endsection
