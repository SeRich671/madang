<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Attribute\StoreRequest;
use App\Http\Requests\Admin\Attribute\UpdateRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attributes = Attribute::paginate(
            $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
        );

        return view('admin.attribute.index', [
            'attributes' => $attributes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Attribute::create($request->validated());

        return redirect()->route('admin.attribute.index')->with('success', 'Pomyślnie dodano cechę produktu');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attribute.edit', [
            'attribute' => $attribute,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Attribute $attribute)
    {
        $attribute->update($request->validated());

        return redirect(route('admin.attribute.index') . '?page=' . $request->get('page'))->with('success', 'Pomyślnie zaktualizowano cechę produktu');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->back()->with('success', 'Pomyślnie usunięto cechę produktu');
    }
}
