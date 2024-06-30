<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(UpdateRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $data = $request->validated();

        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }

        $user->fill($data);

        $user->marketing = (bool)($request->validated('marketing'));

        $user->save();

        return redirect()->back()->with('success', 'Pomyślnie zaktualizowano konto');
    }
}
