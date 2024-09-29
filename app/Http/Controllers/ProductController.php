<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('master.product.index');
    }

    public function data()
    {
        return ProductService::data();
    }

    public function store(ProductRequest $request)
    {
        return ProductService::store($request);
    }
}
