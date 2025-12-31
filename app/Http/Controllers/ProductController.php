<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|alpha_num|unique:products,code',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);
        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Produk ditambahkan');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->transactionDetails()->exists()) {
            return back()->with('error', 'Gagal hapus! Produk sudah digunakan dalam transaksi.');
        }
        $product->delete();
        return back()->with('success', 'Produk dihapus.');
    }
}
