<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Produk;
use App\Models\Jenis;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $keyword = $request->input('search');

        $products = Produk::with(['user', 'jenis'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('produk.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Produk::class);

        $jenis = Jenis::all();

        return view('produk.create', compact('jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);

        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'jenis_id'   => $dataReq['jenis_id'] ?? null,
            'nama'       => $dataReq['name'] ?? $dataReq['nama'],
            'harga_beli' => $dataReq['purchase_price'] ?? $dataReq['harga_beli'],
            'harga_jual' => $dataReq['selling_price'] ?? $dataReq['harga_jual'],
            'stok'       => $dataReq['stock'] ?? $dataReq['stok'],
            'foto'       => null,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $this->authorize('view', $produk);

        return view('produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $jenis = Jenis::all();

        return view('produk.edit', compact('produk', 'jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);

        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'jenis_id'   => $dataReq['jenis_id'] ?? $produk->jenis_id,
            'nama'       => $dataReq['name'] ?? $dataReq['nama_produk'] ?? $dataReq['nama'],
            'harga_beli' => $dataReq['purchase_price'] ?? $dataReq['harga_beli'],
            'harga_jual' => $dataReq['selling_price'] ?? $dataReq['harga_jual'],
            'stok'       => $dataReq['stock'] ?? $dataReq['stok'],
        ];

        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Produk $produk)
{
    $this->authorize('delete', $produk);

    try {
        // 1. Hapus dulu semua item transaksi yang memakai produk ini
        $produk->itemPenjualan()->delete();

        // 2. Simpan path foto
        $fotoPath = $produk->foto;

        // 3. Hapus produk dari database
        $produk->delete();

        // 4. Hapus file foto dari storage jika ada
        if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
            Storage::disk('public')->delete($fotoPath);
        }

        return redirect()->route('produk.index')->with('success', 'Produk beserta riwayatnya berhasil dihapus.');

    } catch (\Exception $e) {
        return redirect()->route('produk.index')->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
    }
}
}