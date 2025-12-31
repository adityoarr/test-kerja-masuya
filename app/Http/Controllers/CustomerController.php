<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'          => 'required|alpha_num|unique:customers,code',
            'name'          => 'required|string|max:255',
            'address'       => 'required|string',
            'province'      => 'required|string',
            'city'          => 'required|string',
            'district'      => 'required|string',
            'sub_district'  => 'required|string',
            'postal_code'   => 'required|numeric',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->transactions()->exists()) {
            return back()->with('error', 'Gagal hapus! Customer ini sudah memiliki riwayat transaksi.');
        }

        $customer->delete();

        return back()->with('success', 'Customer berhasil dihapus.');
    }
}
