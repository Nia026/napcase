<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('user.detail', compact('product'));
    }
}
