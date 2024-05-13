<?php

namespace App\Http\Controllers;

use App\Enums\Order\DeliveryEnum;
use App\Enums\Order\PaymentEnum;
use App\Http\Requests\Order\StoreRequest;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create()
    {
        $addresses = auth()->user()->addresses;
        $cartItems = auth()->user()->cartItems;

        return view('order.create', [
            'addresses' => $addresses,
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

        foreach($cartItemGroups as $branchId => $cartItemGroup) {
            $total = 0;

            foreach ($cartItemGroup as $cartItem) {
                $total += ($cartItem->product->discount_price ?: $cartItem->product->price) * $cartItem->quantity;
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'branch_id' => $branchId,
                'code' => $orderReference,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'company_name' => $data['company_name'],
                'address' => $data['address'],
                'city' => $data['city'],
                'zipcode' => $data['zipcode'],
                'phone' => $data['phone'],
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
