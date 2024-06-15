<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->where('finished_by_client', 1)
            ->paginate(10);

        return view('profile.order.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('profile.order.show', [
            'order' => $order
        ]);
    }

    public function recreate(Order $order)
    {
        $orderLines = OrderLine::whereIn('order_id', Order::where('code', $order->code)->pluck('id'))->get();

        auth()->user()->cartItems()->delete();

        foreach ($orderLines as $orderLine) {
            auth()->user()->cartItems()->create([
                'product_id' => $orderLine->product_id,
                'department_id' => $orderLine->department_id,
                'branch_id' => $orderLine->product->order_branch->id,
                'quantity' => $orderLine->quantity
            ]);
        }

        return redirect()->route('cart.show')->with('success', 'Pomyślnie dodano produkty do koszyka');
    }
}
