<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreRequest;
use App\Mail\ContactEmail;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show($subdomain) {
        $department = Department::where('subdomain', $subdomain)->first();

        if(!$department) {
            return redirect()->route('home');
        }

        $categories = $department->categories()->whereNull('category_id')->get();

        return view('contact.show', [
            'department' => $department,
            'categories' => $categories,
        ]);
    }

    public function store(StoreRequest $request, $subdomain): RedirectResponse
    {
        $department = Department::where('subdomain', $subdomain)->first();

        Mail::to($department->email)
            ->send(
                new ContactEmail(
                    $request->validated('email'),
                    $request->validated('title'),
                    $request->validated('content'),
                    $request->validated('attachment'),
                )
            );

        return redirect()->back()->with('success', 'Pomyślnie wysłano wiadomość');
    }
}
