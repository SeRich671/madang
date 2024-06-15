<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\OrderLine;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($subdomain, Product $product, Category $category) {
        $department = Department::where('subdomain', $subdomain)->first();
        $otherProductIds = OrderLine::where('product_id', $product->id)->get()
            ->pluck('order')
            ->pluck('lines')
            ->flatten(1)
            ->groupBy('product_id')
            ->sortByDesc(function ($item) {
                return $item->count();
            })
            ->take(50)
            ->keys();

        $otherProducts = Product::whereIn('id', $otherProductIds)->where('bought_by_others', 1)->inRandomOrder()->take(6)->get();

        return view('product.show', [
            'product' => $product,
            'categories' => $category->categories,
            'department' => $department,
            'category' => $category,
            'otherProducts' => $otherProducts,
        ]);
    }
}
