<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\Address\StoreRequest;
use App\Http\Requests\Profile\Address\UpdateRequest;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profile.address.index', [
            'addresses' => auth()->user()->addresses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profile.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        auth()->user()->addresses()->create($request->validated());

        return redirect()->route('profile.address.index')->with('success', 'Pomyślnie dodano adres');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        return view('profile.address.edit', [
            'address' => $address
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Address $address)
    {
        $address->update($request->validated());

        return redirect()->route('profile.address.index')->with('success', 'Pomyślnie zaktualizowano adres');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->back()->with('success', 'Pomyślnie usunięto adres');
    }
}
