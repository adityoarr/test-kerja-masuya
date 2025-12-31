<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <label>Kode (AlphaNum Only)</label>
    <input type="text" name="code" class="form-control" required> <label>Nama Produk</label>
    <input type="text" name="name" class="form-control" required>

    <label>Harga</label>
    <input type="number" name="price" class="form-control" required>

    <label>Stok Awal</label>
    <input type="number" name="stock" class="form-control" required>

    <button type="submit" class="btn btn-success mt-2">Simpan</button>
</form>
