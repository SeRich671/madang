<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit');
    }

    public function update(Request $request)
    {
        Cache::put('settings.per_page', $request->input('per_page'));

        return redirect()->back()->with('success', 'Pomyślnie zaktualizowano ustawienia strony');
    }
}
