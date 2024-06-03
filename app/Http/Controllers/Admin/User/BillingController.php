<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Billing\StoreRequest;
use App\Http\Requests\Admin\User\Billing\UpdateRequest;
use App\Models\Billing;
use App\Models\User;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('admin.user.billing.create', [
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, User $user)
    {
        $user->billings()->create($request->validated());

        return redirect()->route('admin.user.edit', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Billing $billing)
    {
        if($billing->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Próbujesz zaktualizować dane do faktury, który nie należy użytkownikowi');
        }

        return view('admin.user.billing.edit', [
            'user' => $user,
            'billing' => $billing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user, Billing $billing)
    {
        if($billing->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Próbujesz zaktualizować dane do faktury, który nie należy użytkownikowi');
        }

        $billing->update($request->validated());

        return redirect()->route('admin.user.edit', $user)->with('success', 'Pomyślnie zaktualizowano dane do faktury użytkownika');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Billing $billing)
    {
        if($billing->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Próbujesz usunąć dane do faktury, który nie należy użytkownikowi');
        }

        $billing->delete();

        return redirect()->back()->with('success', 'Pomyślnie usunięto dane do faktury użytkownika');
    }
}
