@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<h4>Edit Produk</h4>

<form action="{{ route('admin.produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('produk._form')
</form>

@endsection
