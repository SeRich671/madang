<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($subdomain, Product $product, Category $category) {
        return view('product.show', [
            'product' => $product,
        ]);
    }
}
