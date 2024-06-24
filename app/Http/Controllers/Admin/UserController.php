<?php

namespace App\Http\Controllers\Admin;

use App\Enums\User\RoleEnum;
use App\Enums\User\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->input('query'), function ($query) use ($request) {
                return $query->where(function ($query2) use ($request) {
                    return $query2->where('first_name', 'LIKE', '%' . $request->input('query') . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->input('query') . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->input('query') . '%')
                        ->orWhere('login', 'LIKE', '%' . $request->input('query') . '%');
                });
            })
            ->when(!empty($request->input('branch_id', [])), function ($query) use ($request) {
                return $query->whereIn('branch_id', $request->input('branch_id', []));
            })
            ->paginate(
                $request->input('filters.per_page') ? ($request->input('filters.per_page') == 'all' ? 100000 : $request->input('filters.per_page')) : cache()->get('settings.per_page')
            );
        $branches = Branch::pluck('name', 'id');

        return view('admin.user.index', [
            'users' => $users,
            'branches' => $branches,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = StatusEnum::asSelectArray();
        $roles = RoleEnum::asSelectArray();
        $branches = Branch::pluck('name', 'id');

        return view('admin.user.create', [
            'statuses' => $statuses,
            'roles' => $roles,
            'branches' => $branches,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        User::create($data);

        return redirect()->route('admin.user.index')->with('success', 'Pomyślnie dodano użytkownika');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $statuses = StatusEnum::asSelectArray();
        $roles = RoleEnum::asSelectArray();
        $branches = Branch::pluck('name', 'id');
        $orders = $user->orders()->orderByDesc('created_at')->take(20)->get();

        return view('admin.user.edit', [
            'statuses' => $statuses,
            'roles' => $roles,
            'branches' => $branches,
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Pomyślnie zaktualizowano użytkownika');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.user.index')->with('Pomyślnie usunięto użytkownika');
    }
}
