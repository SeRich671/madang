<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductMailing extends Mailable
{
    use Queueable, SerializesModels;

    public array $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function build()
    {
        return $this->subject('Mailing')
            ->markdown('emails.product_mailing')
            ->with(['products' => $this->products]);
    }
}
