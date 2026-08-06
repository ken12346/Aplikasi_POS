@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('layouts.navbar')


<div class="container-fluid mt-4">


    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Dashboard POS
            </h2>

            <p class="text-muted mb-0">
                {{ $tanggalHariIni->translatedFormat('d F Y') }}
            </p>
        </div>


        <div class="text-end">
            <i class="bi bi-calendar3 fs-3 text-primary"></i>
        </div>

    </div>




    @can('viewAny', App\Models\User::class)


    {{-- Statistik --}}
    <div class="row g-4 mb-4">


        <div class="col-md-3">

            <div class="stat-card bg-primary">

                <div>
                    <p>Total Penjualan</p>

                    <h4>
                        Rp {{ number_format($ringkasan['total_penjualan']) }}
                    </h4>
                </div>


                <i class="bi bi-cash-stack"></i>

            </div>

        </div>




        <div class="col-md-3">

            <div class="stat-card bg-success">

                <div>
                    <p>Total Transaksi</p>

                    <h4>
                        {{ $ringkasan['total_transaksi'] }}
                    </h4>
                </div>


                <i class="bi bi-cart-check"></i>

            </div>

        </div>





        <div class="col-md-3">

            <div class="stat-card bg-warning">

                <div>
                    <p>Tunai</p>

                    <h4>
                        Rp {{ number_format($ringkasan['total_cash']) }}
                    </h4>
                </div>


                <i class="bi bi-wallet"></i>

            </div>

        </div>





        <div class="col-md-3">

            <div class="stat-card bg-info">

                <div>
                    <p>Non Tunai</p>

                    <h4>
                        Rp {{ number_format($ringkasan['total_non_tunai']) }}
                    </h4>
                </div>


                <i class="bi bi-credit-card"></i>

            </div>

        </div>


    </div>


    @endcan







    {{-- Produk Warning --}}

    <div class="row g-4 mb-4">


        <div class="col-md-6">


            <div class="card custom-card">


                <div class="card-header">

                    <i class="bi bi-exclamation-triangle text-danger"></i>

                    Stok Menipis

                </div>



                <div class="card-body">


                    <table class="table table-hover">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Stok</th>
                            </tr>
                        </thead>


                        <tbody>


                        @forelse($produkStokRendah as $index=>$produk)

                            <tr>

                                <td>
                                    {{ $produkStokRendah->firstItem()+$index }}
                                </td>

                                <td>
                                    {{ $produk->nama }}
                                </td>

                                <td>
                                    <span class="badge bg-danger">
                                        {{ $produk->stok }}
                                    </span>
                                </td>

                            </tr>


                        @empty

                            <tr>
                                <td colspan="3"
                                    class="text-center text-muted">

                                    Tidak ada data

                                </td>
                            </tr>

                        @endforelse


                        </tbody>

                    </table>


                    {{ $produkStokRendah->links() }}


                </div>


            </div>


        </div>







        <div class="col-md-6">


            <div class="card custom-card">


                <div class="card-header">

                    <i class="bi bi-x-circle text-dark"></i>

                    Produk Habis

                </div>



                <div class="card-body">


                    <table class="table table-hover">


                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Produk</th>
                                <th>Stok</th>

                            </tr>

                        </thead>


                        <tbody>


                        @forelse($produkStokHabis as $index=>$produk)


                            <tr>

                                <td>
                                    {{ $produkStokHabis->firstItem()+$index }}
                                </td>


                                <td>
                                    {{ $produk->nama }}
                                </td>


                                <td>

                                    <span class="badge bg-dark">
                                        {{ $produk->stok }}
                                    </span>

                                </td>


                            </tr>


                        @empty


                            <tr>

                                <td colspan="3"
                                    class="text-center text-muted">

                                    Tidak ada produk habis

                                </td>

                            </tr>


                        @endforelse


                        </tbody>


                    </table>


                    {{ $produkStokHabis->links() }}


                </div>


            </div>


        </div>


    </div>






    {{-- Produk Terlaris --}}

    <div class="card custom-card">


        <div class="card-header">

            <i class="bi bi-star-fill text-warning"></i>

            Produk Terlaris

        </div>



        <div class="card-body">


            <table class="table table-hover">


                <thead>

                    <tr>

                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Terjual</th>

                    </tr>

                </thead>


                <tbody>


                @forelse($produkTerlaris as $produk)

                    <tr>

                        <td>
                            {{ $produk->nama }}
                        </td>

                        <td>
                            {{ $produk->stok }}
                        </td>

                        <td>

                            <span class="badge bg-success">
                                {{ $produk->total_terjual }}
                            </span>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td colspan="3"
                            class="text-center text-muted">

                            Belum ada transaksi

                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>


        </div>


    </div>



</div>





<style>

body {
    background:#f8fafc;
}


.stat-card {

    color:white;
    padding:25px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 8px 20px rgba(0,0,0,.12);

}


.stat-card p {

    margin:0;
    opacity:.8;

}


.stat-card h4 {

    margin-top:10px;
    font-weight:700;

}


.stat-card i {

    font-size:45px;
    opacity:.5;

}



.custom-card {

    border:none;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);

}


.card-header {

    background:white;
    font-weight:700;
    border-bottom:1px solid #eee;
    padding:18px;

}


.table {

    vertical-align:middle;

}


</style>


@endsection