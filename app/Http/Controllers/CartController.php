<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show() {
        $cartItemGroups = CartItem::where('user_id', auth()->id())
            ->orderBy('created_at')
            ->get()
            ->groupBy('department.name');

        return view('cart.show', [
            'cartItemGroups' => $cartItemGroups
        ]);
    }

    public function add(Product $product, Request $request) {
        $department = Department::where('subdomain', current_subdomain())->first();

        $cartItem = CartItem::where('user_id', auth()->user()->id)
            ->where('product_id', $product->id)
            ->where('branch_id', $product->order_branch->id)
            ->where('department_id', $department ? $department->id : $product->categories()->first()->department->id)
            ->first();

        if($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $request->input('quantity')]);
        }else{
            CartItem::create([
                'user_id' => auth()->user()->id,
                'branch_id' => $product->order_branch->id,
                'product_id' => $product->id,
                'department_id' => $department ? $department->id : $product->categories()->first()->department->id,
                'quantity' => $request->input('quantity'),
            ]);
        }

        if(!$request->input('to_div')) {
            return redirect()->back()->with('success', 'Pomyślnie dodano produkt do koszyka');
        }else{
            $url = url()->previous() . $request->input('to_div');
            return redirect($url)->with('success', 'Pomyślnie dodano produkt do koszyka');
        }

    }

    public function recalculate(Request $request)
    {
        $cartsToUpdate = $request->input('quantity');

        foreach ($cartsToUpdate as $id => $quantity) {
            CartItem::where('id', $id)
                ->where('user_id', auth()->id())
                ->update(['quantity' => $quantity]);
        }

        return redirect()->back()->with('success', 'Pomyślnie zaktualizowano koszyk');
    }

    public function delete(CartItem $cartItem) {
        if($cartItem->user_id === auth()->id()) {
            $cartItem->delete();
        }

        return redirect()->back()->with('success', 'Pomyślnie usunięto produkt z koszyka');
    }
}
