<?php

namespace App\Http\Controllers;

use App\Enums\Department\StatusEnum;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Session::remove('subdomain');
        $departments = Department::where('status', StatusEnum::ON)->get();

        return view('welcome', [
            'departments' => $departments
        ]);
    }

    public function department(string $department) {
        $department = Department::where('subdomain', $department)->first();

        if(!$department) {
            return redirect()->route('home');
        }

        $categories = $department->categories()->whereNull('category_id')->get();

        $departmentCategoryIds = $department->categories()->pluck('id');

        $new = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
                $query->whereIn('categories.id', $departmentCategoryIds);
            })
            ->isAvailable()
            ->where(function ($query) {
                return $query->whereDate('created_at', '>', now()->subMonth())
                    ->orWhereDate('updated_at', '>', now()->subMonth());
            })
            ->orderByDesc('updated_at')
            ->take(9)
            ->get();

        $recommended = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
                $query->whereIn('categories.id', $departmentCategoryIds);
            })
            ->isAvailable()
            ->where('is_recommended', 1)
            ->orderByDesc('updated_at')
            ->take(9)
            ->get();

        $lastDeliveries = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
            $query->whereIn('categories.id', $departmentCategoryIds);
        })
            ->isAvailable()
            ->where(function ($query2) {
                return $query2->where(function ($query) {
                    return $query->whereDate('created_at', '>=', now()->subMonth())
                        ->orWhereDate('updated_at', '>=', now()->subMonth());
                })
                    ->orWhere(function ($query) {
                        return $query->whereDate('last_available', '>=', now()->subMonth())
                            ->where('is_available', 1)
                            ->whereDate('updated_at', '>=', 'last_available');
                    });
            })
            ->orderByDesc('updated_at')
            ->take(9)
            ->get();

        $discounted = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
            $query->whereIn('categories.id', $departmentCategoryIds);
        })
            ->isAvailable()
            ->whereNotNull('discount_price')
            ->orderByDesc('updated_at')
            ->take(9)
            ->get();

        return view('home', [
            'department' => $department,
            'categories' => $categories,
            'new' => $new,
            'recommended' => $recommended,
            'discounted' => $discounted,
            'lastDeliveries' => $lastDeliveries,
        ]);
    }

    public function new(Request $request, string $department) {
        $department = Department::where('subdomain', $department)->first();

        if(!$department) {
            return redirect()->route('home');
        }

        $departmentCategoryIds = $department->categories()->pluck('id');

        $categories = $department->categories()->whereNull('category_id')->get();

        $productsQuery = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
            $query->whereIn('categories.id', $departmentCategoryIds);
        })
            ->orderBy('is_available', 'desc')
            ->where(function ($query) use ($request) {
                return $query->whereDate('created_at', '>', now()->subMonth())
                    ->orWhereDate('updated_at', '>', now()->subMonth());
            })
            ->filters(request()->get('filters'))
            ->distinct('id');

        $dynamicAttributes = DB::table('product_attribute')
            ->join('attributes', 'attributes.id', '=', 'product_attribute.attribute_id')
            ->select('product_attribute.attribute_id', 'attributes.name as attribute_name', 'product_attribute.value')
            ->distinct()
            ->get()
            ->groupBy('attribute_id');

//        dd($productsQuery->toRawSql());
        $products = $productsQuery->paginate(
            $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
        );

        return view('home.new', [
            'department' => $department,
            'categories' => $categories,
            'products' => $products,
            'dynamicAttributes' => $dynamicAttributes,
        ]);
    }

    public function recommended(Request $request, string $department) {
        $department = Department::where('subdomain', $department)->first();

        if(!$department) {
            return redirect()->route('home');
        }

        $departmentCategoryIds = $department->categories()->pluck('id');

        $categories = $department->categories()->whereNull('category_id')->get();

        $productsQuery = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
            $query->whereIn('categories.id', $departmentCategoryIds);
        })
            ->orderBy('is_available', 'desc')
            ->where('is_recommended', 1)
            ->filters(request()->get('filters'))
            ->distinct('id');

        $dynamicAttributes = DB::table('product_attribute')
            ->join('attributes', 'attributes.id', '=', 'product_attribute.attribute_id')
            ->select('product_attribute.attribute_id', 'attributes.name as attribute_name', 'product_attribute.value')
            ->distinct()
            ->get()
            ->groupBy('attribute_id');

//        dd($productsQuery->toRawSql());
        $products = $productsQuery->paginate(
            $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
        );

        return view('home.recommended', [
            'department' => $department,
            'categories' => $categories,
            'products' => $products,
            'dynamicAttributes' => $dynamicAttributes,
        ]);
    }

    public function discounted(Request $request, string $department) {
        $department = Department::where('subdomain', $department)->first();

        if(!$department) {
            return redirect()->route('home');
        }

        $departmentCategoryIds = $department->categories()->pluck('id');

        $categories = $department->categories()->whereNull('category_id')->get();

        $productsQuery = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
            $query->whereIn('categories.id', $departmentCategoryIds);
        })
            ->orderBy('is_available', 'desc')
            ->whereNotNull('discount_price')
            ->filters(request()->get('filters'))
            ->distinct('id');

        return $this->getDynamicAttributes($productsQuery, $request, $department, $categories);
    }

    public function lastDeliveries(Request $request, string $department) {
        $department = Department::where('subdomain', $department)->first();

        if(!$department) {
            return redirect()->route('home');
        }

        $departmentCategoryIds = $department->categories()->pluck('id');

        $categories = $department->categories()->whereNull('category_id')->get();

        $productsQuery = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
            $query->whereIn('categories.id', $departmentCategoryIds);
        })->where(function ($query2) {
            return $query2->where(function ($query) {
                return $query->whereDate('created_at', '>=', now()->subMonth())
                    ->orWhereDate('updated_at', '>=', now()->subMonth());
            })
                ->orWhere(function ($query) {
                    return $query->whereDate('last_available', '>=', now()->subMonth())
                        ->where('is_available', 1)
                        ->whereDate('updated_at', '>=', 'last_available');
                });
        })
            ->filters(request()->get('filters'))
            ->distinct('id');

        return $this->getDynamicAttributes($productsQuery, $request, $department, $categories);
    }

    public function category(Request $request, string $department, Category $category) {
        $department = Department::where('subdomain', $department)->first();
        $childCategories = $category->allLeafNodes()->pluck('id');

        $productsQuery = Product::whereHas('categories', function ($query) use ($category, $childCategories) {
                $query->where('categories.id', $category->id);

                if($childCategories->isNotEmpty()) {
                    $query->orWhereIn('categories.id', $childCategories->toArray());
                }
            })
            ->orderBy('is_available', 'desc')
            ->filters(request()->get('filters'))
            ->distinct('id');

        $dynamicAttributes = DB::table('product_attribute')
            ->join('attributes', 'attributes.id', '=', 'product_attribute.attribute_id')
            ->select('product_attribute.attribute_id', 'attributes.name as attribute_name', 'product_attribute.value')
            ->distinct()
            ->get()
            ->groupBy('attribute_id');

//        dd($productsQuery->toRawSql());
        $products = $productsQuery->paginate(
            $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
        );


        if(!$department) {
            return redirect()->route('home');
        }

        return view('home', [
            'department' => $department,
            'category' => $category,
            'categories' => $category->categories,
            'products' => $products,
            'dynamicAttributes' => $dynamicAttributes,
        ]);
    }

    /**
     * @param $productsQuery
     * @param  Request  $request
     * @param $department
     * @param $categories
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    private function getDynamicAttributes(
        $productsQuery,
        Request $request,
        $department,
        $categories
    ): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View {
        $dynamicAttributes = DB::table('product_attribute')
            ->join('attributes', 'attributes.id', '=', 'product_attribute.attribute_id')
            ->select('product_attribute.attribute_id', 'attributes.name as attribute_name', 'product_attribute.value')
            ->distinct()
            ->get()
            ->groupBy('attribute_id');

//        dd($productsQuery->toRawSql());
        $products = $productsQuery->paginate(
            $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
        );

        return view('home.discounted', [
            'department' => $department,
            'categories' => $categories,
            'products' => $products,
            'dynamicAttributes' => $dynamicAttributes,
        ]);
    }
}
