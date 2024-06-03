<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Address\StoreRequest;
use App\Http\Requests\Admin\User\Address\UpdateRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('admin.user.address.create', [
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, User $user)
    {
        $user->addresses()->create($request->validated());

        return redirect()->route('admin.user.edit', $user)->with('success', 'Pomyślnie dodano adres');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Address $address)
    {
        if($address->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Próbujesz zaktualizować adres, który nie należy użytkownikowi');
        }

        return view('admin.user.address.edit', [
            'user' => $user,
            'address' => $address,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user, Address $address)
    {
        if($address->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Próbujesz usunąć adres, który nie należy użytkownikowi');
        }

        $address->update($request->validated());

        return redirect()->route('admin.user.edit', $user)->with('success', 'Pomyślnie zaktualizowano adres użytkownika');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Address $address)
    {
        if($address->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Próbujesz zaktualizować adres, który nie należy użytkownikowi');
        }

        $address->delete();

        return redirect()->back()->with('success', 'Pomyślnie usunięto adres użytkownika');
    }
}
