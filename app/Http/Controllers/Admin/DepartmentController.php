<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Department\FooterTypeEnum;
use App\Enums\Department\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Department\StoreRequest;
use App\Http\Requests\Admin\Department\UpdateRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::query()
            ->orderBy('name')
            ->paginate(
                $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
            );

        return view('admin.department.index', [
            'departments' => $departments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = StatusEnum::asSelectArray();

        return view('admin.department.create', [
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $path = str_replace('public/', '', $request->file('image')->store('public/departments'));
        $data = $request->validated();
        $data['image'] = $path;
        $data['footer_type'] = FooterTypeEnum::DEFAULT;

        Department::create($data);

        return redirect()->route('admin.department.index')->with('success', 'Pomyślnie dodano dział');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $statuses = StatusEnum::asSelectArray();

        return view('admin.department.edit', [
            'statuses' => $statuses,
            'department' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Department $department)
    {
        $data = $request->validated();

        if($request->has('image')) {
            $path = str_replace('public/', '', $request->file('image')->store('public/departments'));
            $data['image'] = $path;
        }

        $department->update($data);

        return redirect()->route('admin.department.index')->with('success', 'Pomyślnie zaktualizowano dział');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if(!$department->categories()->count()) {
            $department->delete();

            return redirect()->route('admin.department.index')->with('success', 'Pomyślnie usunięto dział');
        }

        return redirect()->route('admin.department.index')->with('error', 'Nie można usuwać działu który posiada kategorie');
    }
}
