<?php

namespace App\Http\Controllers;

use App\Models\Penjualan; // sesuaikan namespace model kamu
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * GET /laporan/data?tanggal=2026-09-21
     * atau ?range=7 untuk 7 hari terakhir
     */
    public function data(Request $request)
    {
        $query = Penjualan::query();

        if ($request->filled('range')) {
            $hari = (int) $request->range;
            $mulai = Carbon::now()->subDays($hari - 1)->startOfDay();
            $query->where('created_at', '>=', $mulai);
        } else {
            $tanggal = $request->filled('tanggal')
                ? Carbon::parse($request->tanggal)
                : Carbon::today();

            $query->whereDate('created_at', $tanggal->toDateString());
        }

        $transaksi = $query->orderByDesc('created_at')->get([
            'id',
            'kode_invoice',   // ganti sesuai nama kolom kamu
            'total',
            'metode_bayar',   // 'tunai' | 'nontunai'
            'created_at',
        ]);

        return response()->json([
            'total'   => $transaksi->sum('total'),
            'jumlah'  => $transaksi->count(),
            'data'    => $transaksi->map(function ($t) {
                return [
                    'id'      => $t->kode_invoice ?? ('INV' . $t->id),
                    'waktu'   => $t->created_at->format('d M, H:i'),
                    'jumlah'  => $t->total,
                    'metode'  => $t->metode_bayar,
                ];
            }),
        ]);
    }
}