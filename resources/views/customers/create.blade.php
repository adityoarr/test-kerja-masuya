<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Tambah Customer Baru</h2>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Kembali ke List</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kode Customer (Unik, Huruf/Angka saja)</label>
                <input type="text" name="code" class="form-control" placeholder="Contoh: CUST001" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Customer</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Lengkap (Jalan, No rumah, RT/RW)</label>
                <textarea name="address" class="form-control" rows="2" required></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Provinsi</label>
                    <input type="text" name="province" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kota/Kabupaten</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="district" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kelurahan</label>
                    <input type="text" name="sub_district" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kode Pos</label>
                    <input type="number" name="postal_code" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Simpan Customer</button>
        </form>
    </div>
</body>

</html>
