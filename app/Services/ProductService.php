<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductService
{
    public static function data()
    {
        $data = Product::get();
        return DataTables::of($data)->make(true);
    }

    public static function store($request)
    {
        DB::beginTransaction();
        try {
            $kodebarang = OrderNumberService::createOrderNumber('BRG');

            $barang = new Product();
            $barang->kode_barang            = $kodebarang;
            $barang->nama_barang            = $request->nama_barang;
            $barang->deskripsi            = $request->deskripsi;
            $barang->stok            = $request->stok;
            $barang->status            = $request->status;

            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil dibuat'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
