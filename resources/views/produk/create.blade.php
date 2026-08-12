@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<h4>Tambah Produk</h4>

<form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @include('produk._form')

    <!-- <button type="submit" class="btn btn-success">
        Simpan
    </button>

    <a href="{{ route('produk.index') }}" class="btn btn-secondary">
        Kembali
    </a> -->
</form>

@endsection