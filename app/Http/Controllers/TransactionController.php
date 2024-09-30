<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function pay(Request $request)
    {
        return TransactionService::pay($request);
    }

    public function list()
    {
        return TransactionService::list();
    }

    public function index()
    {
        return view('client.dashboard');
    }

    public function success($id)
    {
        return TransactionService::success($id);
    }
}
