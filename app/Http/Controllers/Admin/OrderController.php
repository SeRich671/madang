<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Order\DeliveryEnum;
use App\Enums\Order\PaymentEnum;
use App\Enums\Order\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statuses = StatusEnum::asSelectArray();
        $orders = Order::where('finished_by_client', 1)
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->when($request->input('code'), function ($query) use ($request) {
                return $query->where('code', 'LIKE', $request->input('code') . '%');
            })
            ->when($request->input('query'), function ($query) use ($request) {
                return $query->whereHas('user', function ($query2) use ($request) {
                    return $query2->where('first_name', 'LIKE', '%' . $request->input('query') . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $request->input('query') . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->input('query') . '%');
                });
            })
            ->when($request->input('status') && $request->input('status') != '', function ($query) use ($request) {
                return $query->where('status', $request->input('status'));
            })
            ->when($request->input('date_from'), function ($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->input('date_from'));
            })
            ->when($request->input('date_to'), function ($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->input('date_to'));
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.order.index', [
            'orders' => $orders,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('admin.order.edit', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Order $order)
    {
        if(
            $request->validated('status') !== $order->status ||
            $request->validated('admin_comment') !== $order->admin_comment ||
            $request->validated('client_comment') !== $order->client_comment
        ){
            $order->statusLogs()->create([
                'old_status' => $order->status,
                'new_status' => $request->validated('status'),
                'admin_comment' => $request->validated('admin_comment'),
                'client_comment' => $request->validated('client_comment'),
            ]);
        }

        $order->update([
            'delivery' => $request->validated('delivery'),
            'delivery_cost' => DeliveryEnum::getPrice($request->validated('delivery')),
            'payment' => $request->validated('payment'),
            'payment_cost' => PaymentEnum::getPrice($request->validated('payment'), $request->validated('delivery')),
            'status' => $request->validated('status'),
            'admin_comment' => $request->validated('admin_comment'),
            'client_comment' => $request->validated('client_comment'),
        ]);

        foreach ($order->lines as $line)
        {
            $line->update([
                'quantity' => ($request->validated('quantity'))[$line->id],
                'unavailable' => ($request->validated('unavailable'))[$line->id],
                'deleted' => $request->validated('deleted')[$line->id],
                'edited_quantity' => $request->validated('quantity')[$line->id] !== $line->quantity && !$line->edited_quantity ? $line->quantity : $line->edited_quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Pomyślnie zaktualizowano zamówienie');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->with('success', 'Pomyślnie usunięto zamówienie');
    }
}
