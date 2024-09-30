<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class OrderNumberService
{
    public static function createOrderNumber($prefix)
    {
        $lastCode = Product::where('kode_barang', 'LIKE', $prefix . '%')
            ->orderBy('kode_barang', 'desc')
            ->value('kode_barang');

        // Jika tidak ada kode sebelumnya, mulai dari 1
        if (!$lastCode) {
            return $prefix . '0001';
        }

        $lastNumber = (int)substr($lastCode, strlen($prefix));
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $prefix . $newNumber;
    }

    public static function createInvoiceNumber($prefix)
    {
        $lastCode = Transaction::where('no_order', 'LIKE', $prefix . '%')
            ->orderBy('no_order', 'desc')
            ->value('no_order');

        // Jika tidak ada kode sebelumnya, mulai dari 1
        if (!$lastCode) {
            return $prefix . '0001';
        }

        $lastNumber = (int)substr($lastCode, strlen($prefix));
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $prefix . $newNumber;
    }
}
