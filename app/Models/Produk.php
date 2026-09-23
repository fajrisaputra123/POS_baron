<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'Produk';

   protected $fillable = [
    'jenis_id',
    'user_id',
    'nama',
    'satuan',
    'harga_beli',
    'harga_jual',
    'stok',
    'foto',
];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Tambahkan relasi ke model Jenis ini
    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }

    public function itemPenjualan()
    {
        return $this->hasMany(ItemPenjualan::class, 'produk_id');
    }
}