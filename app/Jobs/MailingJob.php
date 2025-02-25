<?php

namespace App\Jobs;

use App\Mail\ProductMailing;
use App\Models\LastDelivery;
use App\Models\NewDelivery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class MailingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $products;
    private array $users;

    public function __construct(array $products, array $users)
    {
        $this->products = $products;
        $this->users = $users;
    }

    public function handle(): void
    {
        if (empty($this->products) || empty($this->users)) {
            return;
        }

        // Send the email to all users
        foreach ($this->users as $email) {
            Mail::to($email)->send(new ProductMailing($this->products));
        }

        // Update is_mailed timestamp after successful mailing
        DB::transaction(function () {
            $productIds = collect($this->products)->pluck('product_id')->toArray();

            LastDelivery::whereIn('product_id', $productIds)
                ->whereNull('is_mailed')
                ->update(['is_mailed' => now()]);

            NewDelivery::whereIn('product_id', $productIds)
                ->whereNull('is_mailed')
                ->update(['is_mailed' => now()]);
        });
    }
}

