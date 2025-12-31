<!DOCTYPE html>
<html lang="id">
<head>
    <title>Masuya Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="text-center">
        <h1 class="mb-4">Sistem Tes Masuya</h1>
        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 gap-3">Kelola Produk</a>
            <a href="{{ route('customers.index') }}" class="btn btn-success btn-lg px-4 gap-3">Kelola Customer</a>
            <a href="{{ route('transactions.index') }}" class="btn btn-warning btn-lg px-4 gap-3">Riwayat Transaksi</a>
        </div>
    </div>
</body>
</html>