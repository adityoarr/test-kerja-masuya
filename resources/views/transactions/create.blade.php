<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Input Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h2>Buat Transaksi Baru</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">{{ implode('', $errors->all()) }}</div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Customer</label>
                <select name="customer_id" class="form-control" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->code }} - {{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <h4>Detail Produk</h4>
            <table class="table table-bordered" id="productTable">
                <thead>
                    <tr>
                        <th style="width: 30%">Produk</th>
                        <th style="width: 15%">Harga Satuan</th>
                        <th style="width: 10%">Qty</th>
                        <th>Disc 1 (%)</th>
                        <th>Disc 2 (%)</th>
                        <th>Disc 3 (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <button type="button" class="btn btn-secondary" onclick="addRow()">+ Tambah Produk</button>
            <button type="submit" class="btn btn-primary mt-3">Simpan Transaksi</button>
        </form>
    </div>

    <script>
        let rowIdx = 0;
        const products = @json($products);

        function addRow() {
            let options = '<option value="" data-price="0">Pilih Produk</option>';
            products.forEach(p => {
                options +=
                    `<option value="${p.id}" data-price="${p.price}">${p.code} - ${p.name} (Stok: ${p.stock})</option>`;
            });

            const html = `
                <tr id="row${rowIdx}">
                    <td>
                        <select name="products[${rowIdx}][product_id]" class="form-control" onchange="updatePrice(this, ${rowIdx})" required>
                            ${options}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="products[${rowIdx}][price]" id="price_${rowIdx}" class="form-control" required>
                    </td>
                    <td><input type="number" name="products[${rowIdx}][qty]" class="form-control" min="1" value="1" required></td>
                    <td><input type="number" name="products[${rowIdx}][disc1]" class="form-control" min="0" max="100" value="0"></td>
                    <td><input type="number" name="products[${rowIdx}][disc2]" class="form-control" min="0" max="100" value="0"></td>
                    <td><input type="number" name="products[${rowIdx}][disc3]" class="form-control" min="0" max="100" value="0"></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(${rowIdx})">Hapus</button></td>
                </tr>
            `;
            document.querySelector('#productTable tbody').insertAdjacentHTML('beforeend', html);
            rowIdx++;
        }

        function updatePrice(selectElement, index) {
            const price = selectElement.options[selectElement.selectedIndex].getAttribute('data-price');
            document.getElementById(`price_${index}`).value = price;
        }

        function removeRow(id) {
            document.getElementById(`row${id}`).remove();
        }

        addRow();
    </script>
</body>

</html>
