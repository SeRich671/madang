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

        return view('home', [
            'department' => $department,
            'categories' => $categories,
        ]);
    }

    public function category(Request $request, string $department, Category $category) {
        $department = Department::where('subdomain', $department)->first();
        $childCategories = $category->allLeafNodes()->get()->pluck('id');

        $products = Product::whereHas('categories', function ($query) use ($category, $childCategories) {
                $query->where('categories.id', $category->id);

                if($childCategories->isNotEmpty()) {
                    $query->orWhereIn('categories.id', $childCategories->toArray());
                }
            })
            ->where(function ($query) {
                $query->where('is_available', 1)
                    ->orWhere('last_available', '>', now()->subDays(7));
            })

            ->orderByDesc('created_at')
            ->distinct('id')
            ->paginate(10);


        if(!$department) {
            return redirect()->route('home');
        }

        return view('home', [
            'department' => $department,
            'category' => $category,
            'categories' => $category->categories,
            'products' => $products,
        ]);
    }
}
