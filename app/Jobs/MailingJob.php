<?php

namespace App\Jobs;

use App\Enums\MailingStatus;
use App\Mail\ProductMailing;
use App\Models\LastDelivery;
use App\Models\Mailing;
use App\Models\NewDelivery;
use App\Models\Product;
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

    public function __construct(
        private Mailing $mailing,
        private array $products,
        private array $users
    ) { }

    public function handle(): void
    {
        if (!$this->mailing || empty($this->products) || empty($this->users) || $this->mailing->status !== MailingStatus::CREATED) {
            return;
        }

        try{
            // Send the email to all users
            foreach ($this->users as $email) {
                Mail::to($email)->send(new ProductMailing(
                    Product::whereIn('id', $this->products)->get()
                ));
            }

            // Update is_mailed timestamp after successful mailing
            DB::transaction(function () {
                $productIds = $this->products;

                LastDelivery::whereIn('product_id', $productIds)
                    ->whereNull('is_mailed')
                    ->update(['is_mailed' => now()]);

                NewDelivery::whereIn('product_id', $productIds)
                    ->whereNull('is_mailed')
                    ->update(['is_mailed' => now()]);

                $this->mailing->update([
                    'status' => MailingStatus::FINISHED,
                ]);
            });


        }catch(\Throwable $e) {

            $this->mailing->update([
                'status' => MailingStatus::DELETED,
            ]);

            throw $e;
        }

    }
}

