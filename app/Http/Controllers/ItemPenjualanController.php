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
        return redirect()->route('penjualan.index');
    }

    public function create()
    {
        return redirect()->route('penjualan.create');
    }

    public function store(Request $request)
    {
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

            // Kurangi stok produk
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

            $item->subtotal = $item->kuantitas * $item->harga_satuan;
            $item->save();

            // Total pembayaran
            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function show(string $id)
    {
        // Menampilkan detail transaksi (Mencegah Layar Putih Polos)
        $penjualan = Penjualan::with(['itemPenjualan.produk', 'user'])->findOrFail($id);

        return view('penjualan.show', compact('penjualan'));
    }

    public function edit(string $id)
    {
        return redirect()->route('penjualan.edit', $id);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kuantitas' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request, $id) {
            $item = ItemPenjualan::findOrFail($id);
            $product = Produk::lockForUpdate()->findOrFail($item->produk_id);

            $selisih = $request->kuantitas - $item->kuantitas;

            if ($selisih > 0) {
                // Kuantitas bertambah, cek dan kurangi stok produk
                if ($product->stok < $selisih) {
                    return back()->with('error', 'Stok tidak mencukupi untuk penambahan ini');
                }
                $product->decrement('stok', $selisih);
            } elseif ($selisih < 0) {
                // Kuantitas berkurang, kembalikan selisih ke stok produk
                $product->increment('stok', abs($selisih));
            }

            $item->kuantitas = $request->kuantitas;
            $item->subtotal = $item->kuantitas * ($item->harga_satuan ?? $product->harga_jual);
            $item->save();

            // Update total di tabel penjualan
            $sale = Penjualan::findOrFail($item->penjualan_id);
            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        return back()->with('success', 'Kuantitas item berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $item = ItemPenjualan::findOrFail($id);

            // Kembalikan stok produk saat item dihapus dari keranjang
            $product = Produk::lockForUpdate()->find($item->produk_id);
            if ($product) {
                $product->increment('stok', $item->kuantitas);
            }

            $penjualanId = $item->penjualan_id;
            $item->delete();

            // Recalculate total transaksi
            $sale = Penjualan::findOrFail($penjualanId);
            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        return back()->with('success', 'Item berhasil dihapus dari keranjang');
    }
}