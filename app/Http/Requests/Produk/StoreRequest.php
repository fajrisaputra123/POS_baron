<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'foto'           => 'required|image|mimes:jpg,jpeg,png|max:2048', // Diubah menjadi required
            'jenis_id'       => 'nullable|exists:jenis,id',
            'name'           => 'required|string|max:255',
            'purchase_price' => 'required|integer|min:0',
            'selling_price'  => 'required|integer|min:0',
            'stock'          => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'foto.required'           => 'Foto produk wajib diunggah.', // Pesan error baru
            'foto.image'              => 'File yang diupload harus gambar.',
            'foto.mimes'              => 'Extensi gambar harus JPG, JPEG, PNG.',
            'foto.max'                => 'Maksimal ukuran gambar 2MB.',
            'name.required'           => 'Nama Wajib diisi.',
            'purchase_price.required' => 'Purchase price wajib diisi.',
            'purchase_price.integer'  => 'Purchase price harus diisi bilangan bulat.',
            'selling_price.required' => 'Selling price wajib diisi.',
            'selling_price.integer'   => 'Selling price harus diisi bilangan bulat.',
            'stock.required'          => 'Stock wajib diisi.',
            'stock.integer'           => 'Stock harus diisi angka.',
        ];
    }
}