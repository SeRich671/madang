<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.product.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $branches = Branch::all();
        $attributes = Attribute::all();

        return view('admin.product.create', [
            'categories' => $categories,
            'branches' => $branches,
            'attributes' => $attributes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $path = str_replace('public/', '', $request->file('image')->store('public/departments'));
        $data['img_path'] = $path;

        if(!in_array($data['branch_id'], $data['branches'])) {
            return redirect()->back()->with('error', 'Wybrany domyślny oddział jest niepoprawny');
        }

        DB::beginTransaction();

        $product = Product::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'],
            'price' => $data['price'],
            'size_carton' => $data['size_carton'],
            'count_in_package' => $data['count_in_package'],
            'in_stock' => $data['in_stock'],
            'img_path' => $data['img_path'],
            'is_available' => $data['is_available'],
            'is_recommended' => $data['is_recommended'],
        ]);

        $product->categories()->sync($data['categories']);

        $data['branches'] = collect($data['branches'])->mapWithKeys(function ($item) use ($data) {
            return [
                $item => ['is_default' => $item === $data['branch_id']]
            ];
        });

        $product->branches()->sync($data['branches']);

        $attributes = $request->validated('attributes', []);
        $syncData = [];

        foreach ($attributes as $attribute) {
            if (!empty($attribute['attribute_id']) && !empty($attribute['value'])) {
                $syncData[$attribute['attribute_id']] = ['value' => $attribute['value']];
            }
        }

        $product->attributes()->sync($syncData);

        DB::commit();

        return redirect()->route('admin.product.index')->with('success', 'Pomyślnie dodano produkt');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $branches = Branch::all();
        $attributes = Attribute::all();

        return view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'branches' => $branches,
            'attributes' => $attributes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();

        if($request->file('image')) {
            $path = str_replace('public/', '', $request->file('image')->store('public/departments'));
            $data['img_path'] = $path;
        }

        if(!in_array($data['branch_id'], $data['branches'])) {
            return redirect()->back()->with('error', 'Wybrany domyślny oddział jest niepoprawny');
        }

        DB::beginTransaction();

        $product->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'],
            'price' => $data['price'],
            'size_carton' => $data['size_carton'],
            'count_in_package' => $data['count_in_package'],
            'in_stock' => $data['in_stock'],
            'img_path' => $data['img_path'] ?? $product->img_path,
            'is_available' => $data['is_available'],
            'is_recommended' => $data['is_recommended'],
        ]);

        $product->categories()->sync($data['categories']);

        $data['branches'] = collect($data['branches'])->mapWithKeys(function ($item) use ($data) {
            return [
                $item => ['is_default' => $item === $data['branch_id']]
            ];
        });

        $product->branches()->sync($data['branches']);

        $attributes = $request->input('attributes', []);
        $syncData = [];

        foreach ($attributes as $attribute) {
            if (!empty($attribute['attribute_id']) && !empty($attribute['value'])) {
                $syncData[$attribute['attribute_id']] = ['value' => $attribute['value']];
            }
        }

        $product->attributes()->sync($syncData);

        DB::commit();

        return redirect()->route('admin.product.index')->with('success', 'Pomyślnie zaktualizowano produkt');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->back()->with('success', 'Pomyślnie usunięto produkt');
    }
}
