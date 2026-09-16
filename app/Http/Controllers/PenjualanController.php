<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $user = Auth::user();
        $keyword = $request->input('search');

        $sales = Penjualan::query()
            // 🔒 Filter berdasarkan role
            ->when($user->role && $user->role->name === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            // 🔍 Search nama user
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sale = Penjualan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status'  => 'OPEN'
            ],
            [
                'total_pembayaran'  => 0,
                'metode_pembayaran' => 'CASH'
            ]
        );

        $products = Produk::orderBy('nama')->get();
        $mode = 'create';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        if ($penjualan->status === 'CLOSED') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Transaksi yang sudah selesai tidak bisa diedit.');
        }

        $penjualan->load('itemPenjualan.produk');

        $sale = $penjualan;
        $products = Produk::orderBy('nama')->get();
        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'metode_pembayaran' => 'nullable|in:CASH,QRIS,TRANSFER',
        ]);

        $penjualan->update($request->only(['metode_pembayaran', 'status', 'total_pembayaran']));

        return redirect()->back()->with('success', 'Data penjualan berhasil diperbarui.');
    }

    /**
     * Selesaikan proses checkout pembayaran.
     */
    public function checkout(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:CASH,QRIS,TRANSFER',
            'bayar'             => 'nullable|numeric|min:0',
        ]);

        // Cek jika keranjang kosong
        if ($penjualan->itemPenjualan()->count() === 0) {
            return back()->with('error', 'Keranjang belanja masih kosong.');
        }

        $totalPembayaran = $penjualan->total_pembayaran;
        $bayar = $request->input('bayar', $totalPembayaran);

        // Jika transaksi CASH, pastikan pembayaran mencukupi
        if ($request->metode_pembayaran === 'CASH' && $bayar < $totalPembayaran) {
            return back()->with('error', 'Uang pembayaran kurang!');
        }

        $kembalian = max(0, $bayar - $totalPembayaran);

        DB::transaction(function () use ($request, $penjualan, $bayar, $kembalian) {
            $penjualan->update([
                'metode_pembayaran' => $request->metode_pembayaran,
                'bayar'             => $bayar,
                'kembalian'         => $kembalian,
                'status'            => 'CLOSED',
            ]);
        });

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diselesaikan.');
    }

    /**
     * Menampilkan halaman cetak struk thermal
     */
    public function cetakStruk($id)
    {
        $sale = Penjualan::with(['itemPenjualan.produk', 'user'])->findOrFail($id);
        return view('penjualan.struk', compact('sale'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        $penjualan->load('itemPenjualan.produk', 'user');
        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        DB::transaction(function () use ($penjualan) {
            // Kembalikan stok produk jika transaksi dibatalkan/dihapus
            foreach ($penjualan->itemPenjualan as $item) {
                $item->produk()->increment('stok', $item->kuantitas);
            }

            $penjualan->itemPenjualan()->delete();
            $penjualan->delete();
        });

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}