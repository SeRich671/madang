<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($subdomain, Product $product, Category $category) {
        $department = Department::where('subdomain', $subdomain)->first();

        return view('product.show', [
            'product' => $product,
            'categories' => $category->categories,
            'department' => $department,
            'category' => $category,
        ]);
    }
}
