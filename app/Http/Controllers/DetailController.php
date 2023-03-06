<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries', 'user'])->where('slug', $id)->firstOrFail();
        $relatedProducts = $this->relatedProducts($product->categories_id, $product->id, 4);
        return view('pages.detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
    public function relatedProducts($categoryId, $productId, $limit = 4)
    {
        return Product::where('categories_id', $categoryId)
            ->where('id', '!=', $productId)
            ->inRandomOrder()
            ->with('galleries')
            ->take($limit)
            ->get();
    }
    public function add(Request $request, $id,)
    {
        $product = Cart::where('product_id', $request->input('product_id'))->first();

        if ($product) {
            // produk sudah ada, tinggal menambahkan quantity
            $product->quantity += $request->input('quantity');
            $product->save();
        } else {
            $product = [
                'product_id' => $id,
                'users_id' => Auth::user()->id,
                'quantity' => $request->input('quantity'),
                'size' => $request['size']
            ];

            Cart::create($product);
        }


        return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }
}
