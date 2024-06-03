<?php

namespace App\Http\Controllers;

use App\Enums\Order\DeliveryEnum;
use App\Enums\Order\PaymentEnum;
use App\Http\Requests\Order\StoreRequest;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create()
    {
        $addresses = auth()->user()->addresses;
        $billings = auth()->user()->billings;
        $cartItems = auth()->user()->cartItems;

        return view('order.create', [
            'addresses' => $addresses,
            'billings' => $billings,
            'cartItems' => $cartItems,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $cartItemGroups = CartItem::where('user_id', auth()->id())
            ->get()
            ->groupBy('branch_id');
        $orderReference = Str::uuid();

        DB::beginTransaction();

        foreach($cartItemGroups as $branchId => $cartItemGroup) {
            $total = 0;

            foreach ($cartItemGroup as $cartItem) {
                $total += ($cartItem->product->discount_price ?: $cartItem->product->price) * $cartItem->quantity;
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'branch_id' => $branchId,
                'code' => $orderReference,
                
                'address_first_name' => $data['address']['first_name'],
                'address_last_name' => $data['address']['last_name'],
                'address_company_name' => $data['address']['company_name'],
                'address_address' => $data['address']['address'],
                'address_city' => $data['address']['city'],
                'address_zipcode' => $data['address']['zipcode'],
                'address_phone' => $data['address']['phone'],

                'billing_first_name' => $data['billing']['first_name'],
                'billing_last_name' => $data['billing']['last_name'],
                'billing_company_name' => $data['billing']['company_name'],
                'billing_address' => $data['billing']['address'],
                'billing_city' => $data['billing']['city'],
                'billing_zipcode' => $data['billing']['zipcode'],
                'billing_phone' => $data['billing']['phone'],
                'billing_email' => $data['billing']['email'],
                'billing_nip' => $data['billing']['nip'],
                
                'description' => $data['description'],
                'finished_by_client' => 0,
                'delivery' => $data['delivery'][$branchId],
                'payment' => $data['payment'][$branchId],
                'delivery_cost' => $data['delivery'][$branchId] == DeliveryEnum::COURIER ? '21.00' : '0.00',
                'payment_cost' => $data['delivery'][$branchId] == DeliveryEnum::COURIER && $data['payment'][$branchId] == PaymentEnum::POSTPAYMENT ? '8.00' : '0.00',
                'total' => $total,
            ]);


            foreach ($cartItemGroup as $cartItem) {
                $order->lines()->create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'department_id' => $cartItem->department_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->discount_price ?: $cartItem->product->price
                ]);
            }
        }

        DB::commit();

        return redirect()->route('order.summary', $orderReference);
    }

    public function summary($orderReference)
    {
        $orders = Order::where('code', $orderReference)
            ->where('user_id', auth()->id())
            ->where('finished_by_client', 0)
            ->get();

        if(!$orders->count()) {
            return redirect()->route('department.index', current_subdomain());
        }

        $ordersTotal = 0;
        $ordersAdditional = 0;

        $cartItemGroups = CartItem::where('user_id', auth()->id())
            ->get()
            ->groupBy('department.name');

        foreach ($orders as $order) {
            foreach ($order->lines as $line) {
                $ordersTotal += $line->quantity * ($line->product->discount_price ?: $line->product->price);
            }

            if($order->delivery === DeliveryEnum::COURIER) {
                $ordersAdditional += 21;

                if($order->payment === PaymentEnum::POSTPAYMENT) {
                    $ordersAdditional += 8;
                }
            }
        }



        return view('order.summary', [
            'anyOrder' => $orders->random(),
            'orders' => $orders,
            'cartItemGroups' => $cartItemGroups,
            'ordersTotal' => $ordersTotal,
            'ordersAdditional' => $ordersAdditional,
        ]);
    }

    public function confirm($orderReference) {
        $orders = Order::where('code', $orderReference)
            ->where('user_id', auth()->id())
            ->where('finished_by_client', 0)
            ->get();

        if(!$orders->count()) {
            return redirect()->route('department.index', current_subdomain());
        }

        foreach ($orders as $order) {
            $order->update([
                'finished_by_client' => 1
            ]);
        }

        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('profile.order.index')->with('success', 'Pomyślnie stworzono zamówienie');
    }
}
