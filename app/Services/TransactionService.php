<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;
use Yajra\DataTables\Facades\DataTables;

class TransactionService
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public static function pay($request)
    {
        DB::beginTransaction();
        try {
            $product = Product::where('kode_barang', $request->kode_barang)->first();
            $user = User::find(Auth::id());

            $transaction = Transaction::create([
                'no_order'   => OrderNumberService::createInvoiceNumber('PAY'),
                'user_id'   => Auth::id(),
                'kode_barang'   => $request->kode_barang,
                'qty'   => $request->qty,
                'amount' => $request->harga
            ]);

            // dd($request);

            $payload = [
                'transaction_details' => [
                    'order_id'     => $transaction->no_order,
                    'gross_amount' => $transaction->amount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email'      => $user->email,
                ],
                'item_details' => [
                    [
                        'id'            => $transaction->no_order,
                        'price'         => $transaction->amount,
                        'quantity'      => 1,
                        'name'          => $product->nama_barang,
                        'brand'         => 'Shop',
                        'category'      => 'Shop',
                        'merchant_name' => 'Midtrans',
                    ],
                ],
            ];

            // dd($payload);

            $snapToken = Snap::getSnapToken($payload);
            $transaction->snap_token = $snapToken;
            $transaction->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function list()
    {
        try {
            $user = Auth::id();
            $data = Transaction::with('product')->where('user_id', $user)->get();

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function success($id)
    {
        DB::beginTransaction();
        try {
            $data = Transaction::find($id);
            $data->status = 'success';
            $data->save();

            $product = Product::where('kode_barang', $data->kode_barang)->first();
            $lastest_stok   = $product->stok;
            $product->stok  = $lastest_stok - $data->qty;
            $product->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => 'Pembayaran Berhasil',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public static function data()
    {
        try {
            $data = Transaction::with('user', 'product')->get();
            return Datatables::of($data)->make(true);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
