<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan #{{ $sale->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 58mm;
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-bottom: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        @media print {
            @page { margin: 0; }
            body { padding: 5px; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h3 style="margin: 0; font-size: 16px;">POS FAJRI</h3>
        <small>{{ $sale->created_at->format('d/m/Y H:i') }} | Kasir: {{ $sale->user->name ?? 'Kasir' }}</small>
    </div>

    <div class="line"></div>

    <table>
        @foreach($sale->itemPenjualan as $item)
        <tr>
            <td colspan="2"><b>{{ $item->produk->nama_produk ?? $item->produk->nama ?? 'Produk' }}</b></td>
        </tr>
        <tr>
            <td>{{ $item->kuantitas }} x {{ number_format($item->harga_satuan ?? $item->harga ?? $item->produk->harga ?? 0, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->subtotal ?? ($item->kuantitas * ($item->harga_satuan ?? $item->harga ?? $item->produk->harga ?? 0)), 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td>Total</td>
            <td class="text-right"><b>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td>Bayar ({{ strtoupper($sale->metode_pembayaran) }})</td>
            <td class="text-right">Rp {{ number_format($sale->bayar ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">Rp {{ number_format($sale->kembalian ?? 0, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="text-center">
        <p style="margin: 5px 0;">-- Terima Kasih --</p>
    </div>
</body>
</html>
