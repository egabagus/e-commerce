<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductService
{
    public static function data()
    {
        $data = Product::get();
        return DataTables::of($data)->make(true);
    }

    public static function show($kodebarang)
    {
        try {
            $data = Product::where('kode_barang', $kodebarang)->first();
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public static function store($request)
    {
        DB::beginTransaction();
        try {
            $kodebarang = OrderNumberService::createOrderNumber('BRG');

            $barang = new Product();
            $barang->kode_barang            = $kodebarang;
            $barang->nama_barang            = $request->nama_barang;
            $barang->harga            = $request->harga;
            $barang->deskripsi            = $request->deskripsi;
            $barang->stok            = $request->stok;
            $barang->status            = $request->status;

            $barang->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil dibuat'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $barang = Product::find($id);

            $barang->nama_barang            = $request->nama_barang;
            $barang->harga                  = $request->harga;
            $barang->deskripsi              = $request->deskripsi;
            $barang->stok                   = $request->stok;
            $barang->status                 = $request->status;

            $barang->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil diubah'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function destroy($id)
    {
        DB::beginTransaction();

        try {
            $barang = Product::findOrFail($id);
            $barang->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function image($request, $id)
    {
        DB::beginTransaction();
        try {
            $barang = Product::find($id);

            $foto = $request->foto;
            $fileNamefoto = $foto->getClientOriginalName();

            $barang->foto            = $fileNamefoto;

            Storage::disk('public')->put(
                'master/product-photo/' . $barang->kode_barang . '/' . $fileNamefoto,
                File::get($foto)
            );

            $barang->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Foto produk berhasil di upload'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
