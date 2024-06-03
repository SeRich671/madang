<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $departments = Department::all();

// Convert to key-based array for easy reference
        $categoryItems = [];
        foreach ($categories as $category) {
            $categoryItems[$category->id] = $category->toArray();
            $categoryItems[$category->id]['children'] = [];
        }

// Construct the tree
        foreach ($categoryItems as $key => &$item) {
            if ($item['category_id'] !== null) {
                $categoryItems[$item['category_id']]['children'][] = &$item;
            }
        }

// Remove non-root nodes to clean up the array
        foreach ($categoryItems as $key => &$item) {
            if ($item['category_id'] !== null) {
                unset($categoryItems[$key]);
            }
        }

        $categoryItems = collect($categoryItems)->groupBy('department_id')->toArray();

        return view('admin.category.index', [
            'departments' => $departments,
            'categoryItems' => $categoryItems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        $departments = Department::all();

        if($request->input('for')) {
            $selectedCategory = Category::find($request->input('for'));
            $selectedDepartment = $selectedCategory->department;
        }

        return view('admin.category.create', [
            'categories' => $categories,
            'departments' => $departments,
            'selectedCategory' => $selectedCategory ?? null,
            'selectedDepartment' => $selectedDepartment ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $parentCategory = Category::find($request->input('category_id'));

        if($parentCategory && $parentCategory->department_id != $request->input('department_id')) {
            return redirect()->back()->with('error', 'Dział rodzica oraz dział tworzonej kategorii nie mogą róźnić się');
        }

        Category::create([
            'department_id' => $request->input('department_id'),
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Pomyślnie stworzono kategorię');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::all();
        $departments = Department::all();

        $selectedCategory = $category->category;
        $selectedDepartment = $category->department;

        return view('admin.category.edit', [
            'editedCategory' => $category,
            'categories' => $categories,
            'departments' => $departments,
            'selectedCategory' => $selectedCategory ?? null,
            'selectedDepartment' => $selectedDepartment ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $parentCategory = Category::find($request->input('category_id'));

        if($parentCategory && $parentCategory->department_id != $request->input('department_id')) {
            return redirect()->back()->with('error', 'Dział rodzica oraz dział tworzonej kategorii nie mogą róźnić się');
        }

        $category->update([
            'department_id' => $request->input('department_id'),
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Pomyślnie stworzono kategorię');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Pomyślnie usunięto kategorię');
    }
}
