<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $departments = Department::all();

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
            ->whereDate('created_at', '>', now()->subMonth())
            ->orderByDesc('created_at')
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

        return view('home', [
            'department' => $department,
            'categories' => $categories,
            'new' => $new,
            'recommended' => $recommended,
        ]);
    }

    public function new(string $department) {
        $department = Department::where('subdomain', $department)->first();

        if(!$department) {
            return redirect()->route('home');
        }

        $departmentCategoryIds = $department->categories()->pluck('id');

        $categories = $department->categories()->whereNull('category_id')->get();

        $productsQuery = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
            $query->whereIn('categories.id', $departmentCategoryIds);
        })
            ->isAvailable()
            ->whereDate('created_at', '>', now()->subMonth())
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

        return view('home.new', [
            'department' => $department,
            'categories' => $categories,
            'products' => $products,
            'materials' => $materials,
        ]);
    }

    public function recommended(string $department) {
        $department = Department::where('subdomain', $department)->first();

        if(!$department) {
            return redirect()->route('home');
        }

        $departmentCategoryIds = $department->categories()->pluck('id');

        $categories = $department->categories()->whereNull('category_id')->get();

        $productsQuery = Product::whereHas('categories', function ($query) use ($departmentCategoryIds) {
            $query->whereIn('categories.id', $departmentCategoryIds);
        })
            ->isAvailable()
            ->where('is_recommended', 1)
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

        return view('home.recommended', [
            'department' => $department,
            'categories' => $categories,
            'products' => $products,
            'materials' => $materials,
        ]);
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
            ->isAvailable()
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


        if(!$department) {
            return redirect()->route('home');
        }

        return view('home', [
            'department' => $department,
            'category' => $category,
            'categories' => $category->categories,
            'products' => $products,
            'materials' => $materials,
        ]);
    }
}
