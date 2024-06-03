<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, string $subdomain = '')
    {
        $department = Department::where('subdomain', current_subdomain())->first();

        $productsQuery = Product::isAvailable()
            ->when($department, function ($query) use ($department) {
                return $query->whereHas('categories', function ($query2) use ($department) {
                    return $query2->where('department_id', $department->id);
                });
            })
            ->search($request->input('global_query'))
//            ->filter($request->input('filters'))
//            ->sort($request->input('sort'))
            ->orderByDesc('created_at')
            ->distinct('id');

        $materials = $productsQuery->get()->pluck('material')->unique()->map(function ($material) {
            return explode(',', $material);
        })
            ->flatten(1)
            ->filter(function ($item) {
                return (bool)$item;
            })
            ->map(function ($item) {
                return trim($item);
            })->unique();

        $products = $productsQuery->paginate(12);

        return view('home.search', [
            'department' => $department,
            'categories' => collect(),
            'products' => $products,
            'materials' => $materials,
        ]);
    }
}
