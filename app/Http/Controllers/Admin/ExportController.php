<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ReportHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExportController extends Controller
{
    public function products(Request $request)
    {
        $products = collect();
        foreach ($request->input('product_ids', []) as $product) {
            $products->push(Product::find($product));
        }

        $pdf = PDF::loadView('pdf.product', ['products' => $products, 'exportCount' => $request->input('export_count')]);

        $fileName = 'reports/' . Str::uuid() . '.pdf';

        // Save PDF to storage
        Storage::put($fileName, $pdf->output());

        // Create a record in the ReportHistory model
        $reportHistory = new ReportHistory([
            'user_id' => auth()->user()->id, // Assumes the user is authenticated
            'path' => $fileName
        ]);
        $reportHistory->save();

        return response()->download(storage_path('app/' . $fileName));
    }

    public function download(ReportHistory $report) {
        return response()->download(storage_path('app/') . $report->path);
    }
}
