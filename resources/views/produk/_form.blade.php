@csrf

<div class="row g-4">
    <!-- Kolom Kiri: Form Input Data -->
    <div class="col-lg-8">
        <div class="mb-3">
            <label for="jenis_id" class="form-label fw-semibold">Jenis Produk</label>
            <select name="jenis_id" id="jenis_id" class="form-select @error('jenis_id') is-invalid @enderror" required>
                <option value="">-- Pilih Jenis Produk --</option>
                @foreach($jenis as $item)
                    <option value="{{ $item->id }}"
                        {{ old('jenis_id', $produk->jenis_id ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_jenis ?? $item->nama }}
                    </option>
                @endforeach
            </select>
            @error('jenis_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label fw-semibold">Nama Produk</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $produk->nama ?? '') }}" required placeholder="Masukkan nama produk">
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="harga_beli" class="form-label fw-semibold">Harga Beli</label>
                <input type="number" name="harga_beli" id="harga_beli" class="form-control @error('harga_beli') is-invalid @enderror"
                    value="{{ old('harga_beli', $produk->harga_beli ?? '') }}" required placeholder="0">
                @error('harga_beli')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="satuan_beli" class="form-label fw-semibold">Satuan Beli</label>
                <select name="satuan_beli" id="satuan_beli" class="form-select @error('satuan_beli') is-invalid @enderror" required>
                    <option value="">-- Pilih Satuan --</option>
                    <option value="pcs" {{ old('satuan_beli', $produk->satuan_beli ?? '') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                    <option value="kg" {{ old('satuan_beli', $produk->satuan_beli ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
                    <option value="gram" {{ old('satuan_beli', $produk->satuan_beli ?? '') == 'gram' ? 'selected' : '' }}>Gram</option>
                    <option value="liter" {{ old('satuan_beli', $produk->satuan_beli ?? '') == 'liter' ? 'selected' : '' }}>Liter</option>
                    <option value="box" {{ old('satuan_beli', $produk->satuan_beli ?? '') == 'box' ? 'selected' : '' }}>Box</option>
                    <option value="lusin" {{ old('satuan_beli', $produk->satuan_beli ?? '') == 'lusin' ? 'selected' : '' }}>Lusin</option>
                    <option value="karung" {{ old('satuan_beli', $produk->satuan_beli ?? '') == 'karung' ? 'selected' : '' }}>Karung</option>
                </select>
                @error('satuan_beli')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="harga_jual" class="form-label fw-semibold">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror"
                    value="{{ old('harga_jual', $produk->harga_jual ?? '') }}" required placeholder="0">
                @error('harga_jual')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label fw-semibold">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror"
                value="{{ old('stok', $produk->stok ?? '') }}" required placeholder="0">
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Kolom Kanan: Input Foto & Preview Ringkas -->
    <div class="col-lg-4">
        <div class="p-3 bg-light rounded-3 border text-center">
            <label for="foto" class="form-label fw-semibold d-block text-start mb-2">Foto Produk</label>

            <!-- Box Preview Ukuran Ringkas -->
            <div class="mb-3 d-flex justify-content-center align-items-center bg-white rounded-3 border overflow-hidden mx-auto" style="width: 150px; height: 150px;">
                <img id="preview-img"
                     src="{{ !empty($produk->foto) ? asset('storage/' . $produk->foto) : 'https://via.placeholder.com/150?text=Preview' }}"
                     alt="Preview Foto" class="img-fluid object-fit-cover w-100 h-100">
            </div>

            <input type="file" name="foto" id="foto" class="form-control form-control-sm @error('foto') is-invalid @enderror" accept="image/*" onchange="previewImage(event)">
            <small class="text-muted d-block mt-2 fs-7">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
            @error('foto')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<!-- Tombol Aksi -->
<div class="mt-4 pt-3 border-top d-flex gap-2">
    <button type="submit" class="btn btn-success px-4 fw-semibold">Simpan</button>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary px-4 fw-semibold">Kembali</a>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('preview-img');
            output.src = reader.result;
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>