<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Data Customer</h2>
            <div>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary me-2">Home</a>
                <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Tambah Customer</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Alamat Lengkap</th>
                    <th>Lokasi (Kec/Kel/Kota)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                    <tr>
                        <td>{{ $c->code }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->address }}</td>
                        <td>
                            {{ $c->sub_district }}, {{ $c->district }}<br>
                            {{ $c->city }} - {{ $c->province }} ({{ $c->postal_code }})
                        </td>
                        <td>
                            <form action="{{ route('customers.destroy', $c->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data customer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
