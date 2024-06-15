<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request, string $subdomain = '')
    {
        $department = Department::where('subdomain', current_subdomain())->first();

        $productsQuery = Product::query()
            ->when($department, function ($query) use ($department) {
                return $query->whereHas('categories', function ($query2) use ($department) {
                    return $query2->where('department_id', $department->id);
                });
            })
            ->orderBy('is_available', 'desc')
            ->search($request->input('global_query'))
            ->filters($request->get('filters'))
            ->distinct('id');

        $dynamicAttributes = DB::table('product_attribute')
            ->join('attributes', 'attributes.id', '=', 'product_attribute.attribute_id')
            ->select('product_attribute.attribute_id', 'attributes.name as attribute_name', 'product_attribute.value')
            ->distinct()
            ->get()
            ->groupBy('attribute_id');

//        dd($productsQuery->toRawSql());
        $products = $productsQuery->paginate(
            $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : Product::PER_PAGE
        );

//        dd($products);

        return view('home.search', [
            'department' => $department,
            'categories' => collect(),
            'products' => $products,
            'dynamicAttributes' => $dynamicAttributes,
        ]);
    }
}
