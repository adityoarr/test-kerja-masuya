<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Master Produk</h2>
            <div>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary me-2">Home</a>
                <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>{{ $p->code }}</td>
                        <td>{{ $p->name }}</td>
                        <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td class="{{ $p->stock == 0 ? 'text-danger fw-bold' : '' }}">
                            {{ $p->stock }}
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Hapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
