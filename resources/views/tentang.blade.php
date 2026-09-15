@extends('layouts.app')

@section('title', 'Data User')

@section('content')

@include('layouts.navbar')

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Profil & Detail User</h4>
        </div>
        <div class="card-body">
            <!-- Pesan teks asli kamu -->
            <p class="text-muted italic">IKAN CUPANG</p>
            <hr>

            <!-- Tabel Informasi Detail -->
            <table class="table table-bordered table-striped mt-3">
                <tbody>
                    <tr>
                        <th width="30%">Lokasi (Kota/Provinsi)</th>
                        <td>{{ $user->lokasi ?? 'Tasikmalaya, Jawa Barat' }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon / WA</th>
                        <td>{{ $user->no_hp ?? '083843654957' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Lengkap</th>
                        <td>{{ $user->alamat ?? 'Jl. Telekomunikasi No. 1, Dayeuhkolot' }}</td>
                    </tr>
                    <tr>
                        <th>Status Akun</th>
                        <td>
                            <span class="badge bg-success">Aktif</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Bergabung</th>
                        <td>{{ date('d F Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
