<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\ProductReview;
use App\Models\ProductStock;
use App\Models\Size;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::with('category');

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <div class="btn-group">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                            type="button" 
                                data-toggle="dropdown" 
                                aria-haspopup="true"
                                aria-expanded="false">
                                Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('product.edit', $item->id) . '">
                                Sunting
                            </a>
                            <form action="' . route('product.destroy', $item->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
            </div> 
             ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        $sizes = Size::all();

        return view('pages.admin.product.create', [
            'users' => $users,
            'categories' => $categories,
            'size' => $sizes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        $product =  Product::create($data);

        // if ($request->size) {
        //     $productStock = new ProductStock;
        //     $productStock->product_id = $product->id;
        //     $productStock->size = $request->size;
        //     $productStock->stock = $request->stock;
        //     $productStock->save();
        // } else {
        //     $product->stock = $request->stock;
        //     $product->save();
        // }

        
    // if ($request->has('size') && $request->has('stock')) {
    //     $sizes = explode(',', $request->size);
    //     foreach ($sizes as $size) {
    //         $product->stocks()->create(['size' => $size, 'stock' => $request->stock]);
    //     }
    // } else {
    //     $product->stock = $request->stock;
    //     $product->save();
    // }
    // Create the product stock records
     // Save the product stocks
     $stocks = $request->input('stock');
     $sizes = $request->input('size');
 
     for ($i = 0; $i < count($stocks); $i++) {
         $productStock = new ProductStock();
         $productStock->product_id = $product->id;
         $productStock->stock = $stocks[$i];
         $productStock->size = $sizes[$i] ?? null;
         $productStock->save();
     }
        return redirect()->route('product.index');
    }

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.admin.product.edit', [
            'item' => $item,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('product.index');
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('name', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->get();
        return view('pages.product-search', ['products' => $products, 'query' => $query]);
    }

    public function addReview(Product $product, Request $request)
{
    $validatedData = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string',
    ]);

    $review = new ProductReview();
    $review->product_id = $product->id;
    $review->user_id = Auth::id();
    $review->rating = $validatedData['rating'];
    $review->review = $validatedData['review'];
    $review->save();

    return redirect()->back()->with('success', 'Review added successfully!');
}
}
