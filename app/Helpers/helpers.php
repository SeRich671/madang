<?php

use App\Models\CartItem;
use Illuminate\Support\Facades\Session;

function current_subdomain(){
    return Session::get('subdomain');
}

function cart_count() {
    return CartItem::where('user_id', auth()->id())->count();
}

function cart_ids() {
    return CartItem::where('user_id', auth()->id())->pluck('product_id')->toArray();
}

function pretty_price($price): string
{
    return number_format((float)$price, 2, '.', '');
}
