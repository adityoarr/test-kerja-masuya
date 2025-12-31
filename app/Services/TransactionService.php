<?php
namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;

class TransactionService
{
    public function generateInvoiceNumber()
    {
        // Format: INV/YYMM/Urut (INV/2507/0001)
        $now = Carbon::now();
        $prefix = "INV/" . $now->format('ym') . "/";

        $lastTransaction = Transaction::where('invoice_no', 'like', $prefix . '%')
                            ->orderBy('id', 'desc')
                            ->first();

        if (!$lastTransaction) {
            return $prefix . '0001';
        }

        $lastNumber = (int) substr($lastTransaction->invoice_no, -4);
        return $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    public function calculateNetPrice($price, $d1, $d2, $d3)
    {
        $price -= $price * ($d1 / 100);
        $price -= $price * ($d2 / 100);
        $price -= $price * ($d3 / 100);
        return $price;
    }
}
