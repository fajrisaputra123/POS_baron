@csrf

@if (!empty($produk->foto))
    <div class="mb-2">
        <label>Foto Saat Ini</label><br>
        <img src="{{ asset('storage/' . $produk->foto) }}"
             width="150"
             class="img-thumbnail">
    </div>
@endif

<div class="row">
    <div class="col">
        <div>
            <label>Gambar</label>
            <input type="file"
                   name="foto"
                   onchange="previewImage(this)"
                   class="form-control @error('foto') is-invalid @enderror">
            @error('foto')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <label>Preview Foto</label><br>
            <img id="preview" class="img-thumbnail mt-2" style="display:none" width="150">
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
        value="{{ old('nama', $produk->nama ?? '') }}">
    @error('nama')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Harga Beli</label>
    <input type="number" name="harga_beli" class="form-control @error('harga_beli') is-invalid @enderror"
        value="{{ old('harga_beli', $produk->harga_beli ?? '') }}">
    @error('harga_beli')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Harga Jual</label>
    <input type="number" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror"
        value="{{ old('harga_jual', $produk->harga_jual ?? '') }}">
    @error('harga_jual')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Stok</label>
    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
        value="{{ old('stok', $produk->stok ?? '') }}">
    @error('stok')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<button class="btn btn-success mt-2" type="submit">Simpan</button>
<a href="{{ route('produk.index') }}" class="btn btn-secondary mt-3">Kembali</a>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>