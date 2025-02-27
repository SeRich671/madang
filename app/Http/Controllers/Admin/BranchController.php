<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Branch\StoreRequest;
use App\Http\Requests\Admin\Branch\UpdateRequest;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branches = Branch::query()
            ->orderBy('name')
            ->paginate(
                $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
            );

        return view('admin.branch.index', [
            'branches' => $branches
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Branch::create($request->validated());

        return redirect()->route('admin.branch.index')->with('success', 'Pomyślnie dodano oddział');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('admin.branch.edit', [
            'branch' => $branch,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Branch $branch)
    {
        $branch->update($request->validated());

        return redirect(route('admin.branch.index') . '?page=' . $request->get('page'))->with('success', 'Pomyślnie zaktualizowano oddział');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch): RedirectResponse
    {
        if(!$branch->products()->count()) {
            $branch->delete();

            return redirect()->route('admin.branch.index')->with('success', 'Pomyślnie usunięto oddział');
        }

        return redirect()->route('admin.branch.index')->with('error', 'Nie można usunąć oddziału który posiada przypisane produkty');
    }
}
