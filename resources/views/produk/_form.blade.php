<!-- resources/views/produk/_form.blade.php -->

{{-- Section Media / Foto (Desain Card Modern) --}}
<div class="card border-0 bg-light rounded-4 mb-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-image text-primary fs-5"></i>
            <span class="fw-bold text-dark text-uppercase small tracking-wider">Foto Produk</span>
        </div>
        
        <div class="row g-4 align-items-center">
            @if (!empty($produk->foto)) 
                <div class="col-auto text-center">
                    <span class="text-muted d-block small mb-2">Foto Saat Ini</span>
                    <img src="{{ asset('storage/' . $produk->foto) }}" class="rounded-3 shadow-sm border border-white" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @endif 

            <div class="col">
                <label class="form-label text-muted small fw-medium mb-2">Pilih file foto baru jika ingin mengganti</label>
                <input type="file" name="foto" onchange="previewImage(this)" class="form-control bg-white border-0 shadow-sm p-3 @error('foto') is-invalid @enderror" style="border-radius: 12px; font-size: 0.9rem;">
                @error('foto') 
                    <div class="invalid-feedback d-block mt-2">{{ $message }}</div> 
                @enderror 
            </div>

            <div class="col-auto text-center" id="preview-container" style="display: none;">
                <span class="text-primary d-block small fw-medium mb-2">Pratinjau</span>
                <img id="preview" class="rounded-3 shadow-sm border-2 border-primary" style="width: 100px; height: 100px; object-fit: cover;">
            </div>
        </div>
    </div>
</div>

{{-- Input Nama Produk --}}
<div class="mb-4">
    <label class="form-label fw-semibold text-dark mb-2">Nama Produk</label>
    <input type="text" name="name" class="form-control form-control-lg bg-light border-0 px-4 @error('name') is-invalid @enderror" style="border-radius: 12px; font-size: 0.95rem;" placeholder="Masukkan nama produk..." value="{{ old('name', $produk->nama ?? '') }}">
    @error('name') 
        <div class="invalid-feedback mt-1">{{ $message }}</div> 
    @enderror 
</div>

{{-- Grid Input untuk Harga dan Stok --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <label class="form-label fw-semibold text-dark mb-2">Harga Beli</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-0 text-muted px-3" style="border-radius: 12px 0 0 12px;">Rp</span>
            <input type="number" name="purchase_price" class="form-control form-control-lg bg-light border-0 @error('purchase_price') is-invalid @enderror" style="border-radius: 0 12px 12px 0; font-size: 0.95rem;" placeholder="0" value="{{ old('purchase_price', $produk->harga_beli ?? '') }}">
        </div>
        @error('purchase_price') 
            <div class="text-danger small mt-1" style="font-size: 0.85rem;">{{ $message }}</div> 
        @enderror 
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold text-dark mb-2">Harga Jual</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-0 text-muted px-3" style="border-radius: 12px 0 0 12px;">Rp</span>
            <input type="number" name="selling_price" class="form-control form-control-lg bg-light border-0 @error('selling_price') is-invalid @enderror" style="border-radius: 0 12px 12px 0; font-size: 0.95rem;" placeholder="0" value="{{ old('selling_price', $produk->harga_jual ?? '') }}">
        </div>
        @error('selling_price') 
            <div class="text-danger small mt-1" style="font-size: 0.85rem;">{{ $message }}</div> 
        @enderror 
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold text-dark mb-2">Stok Barang</label>
        <input type="number" name="stock" class="form-control form-control-lg bg-light border-0 px-4 @error('stock') is-invalid @enderror" style="border-radius: 12px; font-size: 0.95rem;" placeholder="0" value="{{ old('stock', $produk->stok ?? '') }}">
        @error('stock') 
            <div class="invalid-feedback mt-1">{{ $message }}</div> 
        @enderror 
    </div>
</div>

{{-- Tombol Aksi Akhir (Clean Action Bar) --}}
<div class="d-flex align-items-center gap-3 mt-5 border-top pt-4">
    <button type="submit" class="btn btn-primary px-4 py-2½ fw-medium shadow-sm" style="border-radius: 10px; font-size: 0.9rem;">
        <i class="bi bi-check2-circle me-1"></i> Simpan Data
    </button> 
    <a href="{{ route('produk.index') }}" class="btn btn-light px-4 py-2½ text-secondary fw-medium" style="border-radius: 10px; font-size: 0.9rem;">
        Batal
    </a>
</div>

{{-- Script Pratinjau Gambar Otomatis --}}
<script> 
function previewImage(input) { 
    const preview = document.getElementById('preview'); 
    const container = document.getElementById('preview-container'); 
    const file = input.files[0]; 
    
    if (file) { 
        preview.src = URL.createObjectURL(file); 
        container.style.display = 'block'; 
    } else {
        container.style.display = 'none';
    }
} 
</script>
