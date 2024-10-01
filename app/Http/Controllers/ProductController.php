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

    public function shopdata()
    {
        return ProductService::shopdata();
    }

    public function show($kodebarang)
    {
        return ProductService::show($kodebarang);
    }

    public function store(ProductRequest $request)
    {
        return ProductService::store($request);
    }

    public function update(ProductRequest $request, $id)
    {
        return ProductService::update($request, $id);
    }

    public function image(Request $request, $id)
    {
        return ProductService::image($request, $id);
    }

    public function destroy($id)
    {
        return ProductService::destroy($id);
    }
}
