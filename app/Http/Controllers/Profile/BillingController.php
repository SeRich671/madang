<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\Billing\StoreRequest;
use App\Http\Requests\Profile\Billing\UpdateRequest;
use App\Models\Billing;
use Illuminate\Http\RedirectResponse;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profile.billing.index', [
            'billings' => auth()->user()->billings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        auth()->user()->billings()->create($request->validated());

        return redirect()->route('profile.billing.index')->with('success', 'Pomyślnie dodano dane do faktury');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profile.billing.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billing $billing)
    {
        return view('profile.billing.edit', [
            'billing' => $billing
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Billing $billing): RedirectResponse
    {
        $billing->update($request->validated());

        return redirect()->route('profile.billing.index')->with('success', 'Pomyślnie zaktualizowano dane do faktury');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Billing $billing): RedirectResponse
    {
        $billing->delete();

        return redirect()->back()->with('success', 'Pomyślnie usunięto dane do faktury');
    }
}
