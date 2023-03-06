<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::paginate($request->input('limit', 12));

        $productstock = ProductStock::where('stock', '>', 0)->get();
        return view('pages.category', [
            'categories' => $categories,
            'products' => $products,
            'productstock' => $productstock
        ]);
    }

    public function detail(Request $request, $slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('categories_id', $category->id)->paginate($request->input('limit', 12));

        return view('pages.category',[
            'categories' => $categories,
            'category' => $category,
            'products' => $products
        ]);
    }
}
