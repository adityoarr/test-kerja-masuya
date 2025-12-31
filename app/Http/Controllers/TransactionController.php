<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Customer;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    protected $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $transactions = Transaction::with('customer')->orderBy('created_at', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['details', 'customer'])->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('transactions.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'products' => 'required|array',
            'products.*.qty' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $cust = Customer::findOrFail($request->customer_id);

            $trx = Transaction::create([
                'invoice_no' => $this->service->generateInvoiceNumber(),
                'date' => now(),
                'customer_id' => $cust->id,
                'cust_code_snapshot' => $cust->code,
                'cust_name_snapshot' => $cust->name,
                'cust_address_snapshot' => $cust->address . ', ' . $cust->city,
                'total_amount' => 0
            ]);

            $grandTotal = 0;

            foreach ($request->products as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok {$product->name} tidak cukup!");
                }

                $netPrice = $this->service->calculateNetPrice(
                    $product->price,
                    $item['disc1'] ?? 0,
                    $item['disc2'] ?? 0,
                    $item['disc3'] ?? 0
                );

                $subtotal = $netPrice * $item['qty'];
                $grandTotal += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $product->id,
                    'product_code_snapshot' => $product->code,
                    'product_name_snapshot' => $product->name,
                    'qty' => $item['qty'],
                    'price' => $product->price,
                    'disc1' => $item['disc1'] ?? 0,
                    'disc2' => $item['disc2'] ?? 0,
                    'disc3' => $item['disc3'] ?? 0,
                    'net_price' => $netPrice,
                    'subtotal' => $subtotal
                ]);

                $product->decrement('stock', $item['qty']);
            }

            $trx->update(['total_amount' => $grandTotal]);

            DB::commit();
            return redirect()->route('transactions.create')->with('success', 'Transaksi Berhasil! INV: ' . $trx->invoice_no);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }
}
