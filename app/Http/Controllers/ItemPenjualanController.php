<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'product_id' => 'required|exists:produk,id',
        'quantity' => 'required|integer|min:1'
    ]);

    DB::transaction(function () use ($request) {

        $sale = Penjualan::where('user_id', Auth::id())
            ->where('status', 'OPEN')
            ->firstOrFail();

        $product = Produk::lockForUpdate()->findOrFail($request->product_id);

        // ✅ Cek stok (pakai abort biar transaksi aman)
        if ($product->stok < $request->quantity) {
            abort(400, 'Produk stok tidak mencukupi');
        }

        // ⬇️ Kurangi stok
        $product->decrement('stok', $request->quantity);

        // Cari item lama
        $item = ItemPenjualan::where('penjualan_id', $sale->id)
            ->where('produk_id', $product->id)
            ->lockForUpdate()
            ->first();

        if ($item) {
            // ✅ UPDATE
            $item->kuantitas = $item->kuantitas + $request->quantity;
        } else {
            // ✅ CREATE (PASTIKAN kuantitas ADA)
            $item = new ItemPenjualan();
            $item->penjualan_id = $sale->id;
            $item->produk_id = $product->id;
            $item->kuantitas = $request->quantity; // 🔥 WAJIB
            $item->harga_satuan = $product->harga_jual;
        }

        // hitung subtotal
        $item->subtotal = $item->kuantitas * $item->harga_satuan;
        $item->save();

        // 🔢 update total pembayaran
        $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
        $sale->save();
    });

    return back();
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request, $itempenjualan) {
            $product = $itempenjualan->produk()->lockForUpdate()->first();
            $selisih = $request->quantity - $itempenjualan->kuantitas;

            // 🔍 Jika qty bertambah -> kurangi stok
            if ($selisih > 0) {
                if ($product->stok < $selisih) {
                    return redirect()->route('penjualan.create')->with('errors', 'Stok tidak mencukupi');
                }
                $product->decrement('stok', $selisih);
            }

            // 🔍 Jika qty berkurang -> kembalikan stok
            if ($selisih < 0) {
                $product->increment('stok', abs($selisih));
            }

            // ⚙️ Update item
            $itempenjualan->update([
                'kuantitas' => $request->quantity,
                'subtotal' => $request->quantity * $itempenjualan->harga_satuan
            ]);

            // ⚙️ Update total penjualan
            $itempenjualan->penjualan->update([
                'total_pembayaran' => $itempenjualan->penjualan->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPenjualan $itempenjualan)
    {
        $this->authorize('delete', $ItemPenjualan);
        
        DB::transaction(function () use ($itempenjualan) {
            $product = $itempenjualan->produk;
            $sale = $itempenjualan->penjualan;

            // ⬆️ Kembalikan stok
            $product->increment('stok', $itempenjualan->kuantitas);

            // ❌ Hapus item
            $itempenjualan->delete();

            // 🔄 Update total penjualan
            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
            ]);
        }); 

        return back();
    }
}