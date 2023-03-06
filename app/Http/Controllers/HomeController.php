<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::take(6)->get();
        // $products = Product::with('galleries')->take(8)->get();
         // query untuk mengambil data produk, termasuk data galeri dan varian
    $products = Product::with(['galleries', 'product_stocks'])
    ->orderBy('created_at', 'desc')
    ->distinct('name')
    ->take(8)
    ->get();
    
    $productstrend = Product::with(['galleries', 'product_stocks'])
    ->select('products.*', DB::raw('SUM(transaction_details.quantity) as total_sold'))
    ->leftJoin('transaction_details', 'transaction_details.products_id', '=', 'products.id')
    ->groupBy('products.id')
    ->having('total_sold', '>', 0)
    ->orderBy('total_sold', 'desc')
    ->take(8)
    ->get();

    $productstock = ProductStock::where('stock', '>', 0)->get();

        return view('pages.home', [
            'categories' => $categories,
            'products' => $products,
            'productstrend' => $productstrend,
            'productstock' => $productstock
        ]);
    }
}
