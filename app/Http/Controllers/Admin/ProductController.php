<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Models\Attribute;
use App\Models\Branch;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->search($request->input('query'))
            ->when($request->input('is_available') != '', function ($query) use ($request) {
                return $query->where('is_available', $request->input('is_available'));
            })
            ->when($request->input('img_path') != '', function ($query) use ($request) {
                if($request->input('img_path') == 1) {
                    return $query->whereNotNull('img_path');
                }else {
                    return $query->whereNull('img_path');
                }
            })
            ->when($request->input('is_recommended') != '', function ($query) use ($request) {
                return $query->where('is_recommended', $request->input('is_recommended'));
            })
            ->when($request->input('in_stock') != '', function ($query) use ($request) {
                if($request->input('in_stock') == 1) {
                    return $query->where('in_stock', '>', 0);
                }else {
                    return $query->where('in_stock', '<=', 0);
                }
            })
            ->when(!empty($request->input('category_id', [])), function ($query) use ($request) {
                return $query->whereHas('categories', function ($query2) use ($request) {
                    return $query2->whereIn('categories.id', $request->input('category_id'));
                });
            })
            ->paginate(
                $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
            );

        $categories = Category::pluck('name', 'id');

        return view('admin.product.index', [
            'products' => $products,
            'categories' => $categories,
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

        $stickers = Product::isAvailable()
            ->where('name', 'LIKE', 'naklej%')
            ->pluck('name', 'id');

        return view('admin.product.create', [
            'categories' => $categories,
            'branches' => $branches,
            'attributes' => $attributes,
            'stickers' => $stickers
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

        DB::beginTransaction();

        $product = Product::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'],
            'price' => pretty_price($data['price']),
            'discount_price' => $data['discount_price'] ? pretty_price($data['discount_price']) : null,
            'size_carton' => $data['size_carton'],
            'count_in_package' => $data['count_in_package'],
            'in_stock' => $data['in_stock'],
            'img_path' => $data['img_path'],
            'is_available' => $data['is_available'],
            'is_recommended' => $data['is_recommended'],
            'bought_by_others' => $data['bought_by_others'],
            'later_delivery' => $data['later_delivery'],
        ]);

        $product->categories()->sync($data['categories']);

        if(!empty($data['stickers'])) {
            $product->stickers()->sync($data['stickers']);
        }

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

        if($product->in_stock > 0) {
            $product->markAsNewDelivery();
        }

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
        $stickers = Product::isAvailable()
            ->where('name', 'LIKE', 'naklej%')
            ->pluck('name', 'id');

        return view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'branches' => $branches,
            'attributes' => $attributes,
            'stickers' => $stickers,
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

        DB::beginTransaction();

        if($product->is_available == 1 && $data['is_available'] == '0') {
            $product->update(['last_available' => now()]);
        }

        if($product->in_stock == 0 && $data['in_stock'] > 0) {
            $product->markAsLastDelivery();
            $product->markAsnewDelivery();
        }

        $product->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'],
            'price' => pretty_price($data['price']),
            'discount_price' => $data['discount_price'] ? pretty_price($data['discount_price']) : null,
            'size_carton' => $data['size_carton'],
            'count_in_package' => $data['count_in_package'],
            'in_stock' => $data['in_stock'],
            'img_path' => $data['img_path'] ?? $product->img_path,
            'is_available' => $data['is_available'],
            'is_recommended' => $data['is_recommended'],
            'bought_by_others' => $data['bought_by_others'],
            'later_delivery' => $data['later_delivery'],
        ]);



        $product->categories()->sync($data['categories']);

        if(!empty($data['stickers'])) {
            $product->stickers()->sync($data['stickers']);
        }

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

        if((int)$data['in_stock'] <= 0 || (int)$data['is_available'] == 0) {
            CartItem::where('product_id', $product->id)->delete();
        }

        DB::commit();

        return redirect(route('admin.product.index') . '?page=' . $request->get('page'))->with('success', 'Pomyślnie zaktualizowano produkt');
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
