<?php

namespace App\Http\Controllers\Admin\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Department\Link\StoreRequest;
use App\Http\Requests\Admin\Department\Link\UpdateRequest;
use App\Models\Department;
use App\Models\DepartmentLink;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Department $department)
    {
        return view('admin.department.link.create', [
            'department' => $department
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Department $department)
    {
        DepartmentLink::create(array_merge($request->validated(), ['department_id' => $department->id]));

        return redirect()->route('admin.department.edit', $department);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department, DepartmentLink $link)
    {
        return view('admin.department.link.edit', [
            'department' => $department,
            'link' => $link
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Department $department, DepartmentLink $link)
    {
        $link->update(array_merge($request->validated(), ['department_id' => $department->id]));

        return redirect()->route('admin.department.edit', $department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department, DepartmentLink $link)
    {
        $link->delete();

        return redirect()->route('admin.department.edit', $department);
    }
}
