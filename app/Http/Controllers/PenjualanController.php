<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PenjualanController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $user = Auth::user();
        $keyword = $request->input('search');

        $sales = Penjualan::query()
            ->when($user->role->name === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact('sales'));
    }


    /**
     * Show POS form.
     */
    public function create(SearchRequest $request)
    {
        $sale = Penjualan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status'  => 'OPEN'
            ],
            [
                'total_pembayaran' => 0,
                'metode_pembayaran' => 'CASH'
            ]
        );

        $keyword = $request->input('search');

        $products = Produk::when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%');
        })
            ->orderBy('nama')
            ->get();

        $mode = 'create';

        return view('penjualan.pos', compact(
            'sale',
            'products',
            'mode'
        ));
    }


    /**
     * Display detail transaksi.
     */
    public function show(Penjualan $penjualan)
    {
        $sale = $penjualan;

        $sale->load(
            'itemPenjualan.produk',
            'user'
        );

        return view('penjualan.show', compact('sale'));
    }


    /**
     * Show edit POS.
     */
    public function edit(Penjualan $penjualan)
    {
        // Transaksi selesai tidak boleh diedit
        if ($penjualan->status === 'COMPLETED') {

            return redirect()
                ->route('penjualan.show', $penjualan->id)
                ->with('error', 'Transaksi sudah selesai dan tidak dapat diedit.');
        }


        $sale = $penjualan;

        $sale->load('itemPenjualan');

        $products = Produk::orderBy('nama')->get();

        $mode = 'edit';


        return view('penjualan.pos', compact(
            'sale',
            'products',
            'mode'
        ));
    }


    /**
     * Update transaksi / selesai pembayaran.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        // Proteksi transaksi selesai
        if ($penjualan->status === 'COMPLETED') {

            return redirect()
                ->route('penjualan.show', $penjualan->id)
                ->with('error', 'Transaksi sudah selesai dan tidak dapat diubah.');
        }


        $request->validate([
            'payment_method' => 'required|in:CASH,QRIS'
        ]);


        if ($penjualan->itemPenjualan()->count() === 0) {

            return back()
                ->with('error', 'Keranjang masih kosong.');
        }


        DB::transaction(function () use ($penjualan, $request) {

            $total = $penjualan
                ->itemPenjualan()
                ->sum('subtotal');


            $penjualan->update([
                'metode_pembayaran' => $request->payment_method,
                'total_pembayaran'  => $total,
                'status'            => 'COMPLETED'
            ]);
        });


        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil diselesaikan.');
    }


    /**
     * Delete transaksi.
     */
    public function destroy(Penjualan $penjualan)
    {
        // Transaksi selesai tidak boleh dihapus
        if ($penjualan->status === 'COMPLETED') {

            return redirect()
                ->route('penjualan.show', $penjualan->id)
                ->with('error', 'Transaksi selesai tidak dapat dihapus.');
        }


        // Kasir hanya boleh hapus transaksi miliknya
        if ($penjualan->user_id !== Auth::id()) {

            return redirect()
                ->route('penjualan.index')
                ->with('error', 'Anda tidak memiliki akses menghapus transaksi ini.');
        }


        DB::transaction(function () use ($penjualan) {


            foreach ($penjualan->itemPenjualan as $item) {

                // kembalikan stok produk
                $item->produk->increment(
                    'stok',
                    $item->kuantitas
                );
            }


            // hapus item transaksi
            $penjualan->itemPenjualan()->delete();


            // hapus transaksi
            $penjualan->delete();
        });


        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }
}
