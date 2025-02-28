<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MailingStatus;
use App\Http\Controllers\Controller;
use App\Jobs\MailingJob;
use App\Models\LastDelivery;
use App\Models\Mailing;
use App\Models\NewDelivery;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MailingController extends Controller
{
    public function index() {
        $mailings = Mailing::query()
            ->orderByDesc('created_at')
            ->paginate(10);
        $mailingProducts = LastDelivery::where('listed_till', '>=', now())
            ->whereNull('is_mailed')
            ->whereHas('product', function ($query) {
                return $query->isAvailable();
            })
            ->with('product')
            ->get()
            ->merge(
                NewDelivery::where('listed_till', '>=', now())
                    ->whereHas('product', function ($query) {
                        return $query->isAvailable();
                    })
                    ->with('product')
                    ->whereNull('is_mailed')
                    ->get()
            )
            ->pluck('product.name');
        $users = User::where('marketing', true)->pluck('email')->toArray();

        return view('admin.mailing.index', compact('mailings', 'mailingProducts', 'users'));
    }

    public function destroy(Mailing $mailing) {
        if($mailing->status === MailingStatus::CREATED) {
            $mailing->update(['status' => MailingStatus::DELETED]);

            return redirect()->route('admin.mailing.index')->with('success', 'Mailing został skasowany');
        }

        return redirect()->route('admin.mailing.index')->with('error', 'Mailing już jest usunięty lub jest w procesie wysyłania / ukończony');
    }

    public function sendMailing(Request $request): RedirectResponse
    {
        $products = LastDelivery::where('listed_till', '>=', now())
            ->whereNull('is_mailed')
            ->whereHas('product', function ($query) {
                return $query->isAvailable();
            })
            ->get()
            ->merge(
                NewDelivery::where('listed_till', '>=', now())
                    ->whereHas('product', function ($query) {
                        return $query->isAvailable();
                    })
                    ->whereNull('is_mailed')
                    ->get()
            )
            ->pluck('product_id');

        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'Brak produktów mailingu.');
        }

        $users = User::where('marketing', true)->pluck('email')->toArray();

        if (empty($users)) {
            return redirect()->back()->with('error', 'Brak użytkowników do mailingu.');
        }

        $mailing = Mailing::create([
            'emails' => implode(',', $users),
            'products' => implode(', ', Product::whereIn('id', $products->toArray())->pluck('name')->toArray())
        ]);

        MailingJob::dispatch($mailing, $products->toArray(), $users);

        return redirect()->back()->with('success', 'Zlecono wysyłke maili!');
    }

}

