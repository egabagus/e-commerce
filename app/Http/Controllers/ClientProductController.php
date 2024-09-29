<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientProductController extends Controller
{
    public function index()
    {
        return view('client.shop.index');
    }

    public function product()
    {
        return view('client.shop.product');
    }
}
