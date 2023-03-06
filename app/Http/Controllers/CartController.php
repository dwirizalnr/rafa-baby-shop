<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // $carts = Cart::with(['product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();
        $carts = Cart::with(['product.product_stocks', 'product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();
        $carts = Cart::latest()->get();
        $carts = Cart::latest()->get();
        return view('pages.cart', [
            'carts' => $carts
        ]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        $cart->quantity = $request->quantity;
        $cart->size = $request->size;
        $cart->save();

        // return response()->json(['message' => 'Cart updated successfully']);
        return redirect()->route('cart');
    }

    public function success()
    {
        return view('pages.success');
    }
}
