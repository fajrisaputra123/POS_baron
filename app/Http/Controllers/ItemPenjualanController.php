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
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Perbaikan: Menyesuaikan validasi dengan nama input di Blade (produk_id & kuantitas)
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'kuantitas' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {
            $sale = Penjualan::where('user_id', Auth::id())
                ->where('status', 'OPEN')
                ->firstOrFail();

            $product = Produk::lockForUpdate()->findOrFail($request->produk_id);

            // Cek stok
            if ($product->stok < $request->kuantitas) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
            }

            // Kurangi stok
            $product->decrement('stok', $request->kuantitas);

            // Update / insert item penjualan
            $item = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($item) {
                $item->kuantitas += $request->kuantitas;
            } else {
                $item = new ItemPenjualan([
                    'penjualan_id' => $sale->id,
                    'produk_id'    => $product->id,
                    'kuantitas'    => $request->kuantitas,
                    'harga_satuan' => $product->harga_jual,
                ]);
            }

            // Hitung subtotal
            $item->subtotal = $item->kuantitas * $item->harga_satuan;
            $item->save();

            // Total pembayaran
            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}