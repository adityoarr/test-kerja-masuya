<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Invoice {{ $transaction->invoice_no }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }
    </style>
</head>

<body class="p-4">
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">&laquo; Kembali</a>
        </div>

        <div class="invoice-box">
            <div class="row mb-4">
                <div class="col-6">
                    <h2 class="text-primary">INVOICE</h2>
                    <h5>{{ $transaction->invoice_no }}</h5>
                    <p>Tanggal: {{ $transaction->date }}</p>
                </div>
                <div class="col-6 text-end">
                    <h5>Kepada Yth:</h5>
                    <strong>{{ $transaction->cust_name_snapshot }}</strong><br>
                    {{ $transaction->cust_address_snapshot }}
                </div>
            </div>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Disc (%)</th>
                        <th class="text-end">Total Net</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->details as $detail)
                        <tr>
                            <td>
                                {{ $detail->product_name_snapshot }} <br>
                                <small class="text-muted">{{ $detail->product_code_snapshot }}</small>
                            </td>
                            <td class="text-center">{{ $detail->qty }}</td>
                            <td class="text-end">{{ number_format($detail->price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if ($detail->disc1 > 0)
                                    {{ $detail->disc1 }}%
                                @endif
                                @if ($detail->disc2 > 0)
                                    + {{ $detail->disc2 }}%
                                @endif
                                @if ($detail->disc3 > 0)
                                    + {{ $detail->disc3 }}%
                                @endif
                                @if ($detail->disc1 == 0 && $detail->disc2 == 0 && $detail->disc3 == 0)
                                    -
                                @endif
                            </td>
                            <td class="text-end">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Grand Total</th>
                        <th class="text-end">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
