<?php

namespace App\Http\Controllers;

use App\Jobs\MailingJob;
use App\Models\LastDelivery;
use App\Models\NewDelivery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailingController extends Controller
{
    public function sendMailing(Request $request)
    {
        // Fetch products from both tables where listed_till is in the future and not mailed yet
        $products = LastDelivery::where('listed_till', '>=', now())
            ->whereNull('is_mailed')
            ->get()
            ->merge(NewDelivery::where('listed_till', '>=', now())->whereNull('is_mailed')->get());

        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'Brak produktów mailingu.');
        }

        // Fetch users (assuming we send to users who have marketing enabled)
        $users = User::where('marketing', true)->pluck('email')->toArray();

        if (empty($users)) {
            return redirect()->back()->with('error', 'Brak użytkowników do mailingu.');
        }

        // Dispatch the job
        MailingJob::dispatch($products->toArray(), $users);

        return redirect()->back()->with('success', 'Zlecono wysyłke maili!');е 
    }

}

