<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function products(Request $request)
    {
        $products = collect();
        foreach ($request->input('product_ids', []) as $product) {
            $products->push(Product::find($product));
        }

        $pdf = PDF::loadView('pdf.product', ['products' => $products]);

        return $pdf->download(now()->format('d-m-Y') . '.pdf');
    }
}
