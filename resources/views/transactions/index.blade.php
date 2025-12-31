<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Riwayat Transaksi</h2>
            <div>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary me-2">Home</a>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">+ Transaksi Baru</a>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>{{ $t->invoice_no }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->date)->format('d-m-Y') }}</td>
                        <td>
                            {{ $t->cust_name_snapshot }} <br>
                            <small class="text-muted">{{ $t->cust_code_snapshot }}</small>
                        </td>
                        <td>Rp {{ number_format($t->total_amount, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('transactions.show', $t->id) }}"
                                class="btn btn-info btn-sm text-white">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
