<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductStock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductStockController extends Controller
{
    public function index()
    {
        // // Tampilkan semua data product stock
        // $productStocks = ProductStock::all();
        if (request()->ajax()) {
            $query = ProductStock::with(['product']);
    
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" 
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown" 
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '">
                                    <a class="dropdown-item" href="' . route('transaction.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('transaction.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
    

        return view('pages.admin.product_stock.index');
    }

    public function create()
    {
        // Tampilkan halaman form create product stock
        return view('product_stock.create');
    }

    public function store(Request $request)
    {
        // Simpan data product stock yang baru
        $productStock = new ProductStock;
        $productStock->product_id = $request->product_id;
        $productStock->size = $request->size;
        $productStock->stock = $request->stock;
        $productStock->save();

        return redirect()->route('product_stock.index');
    }

    public function edit(ProductStock $productStock)
    {
        // Tampilkan halaman form edit product stock
        return view('product_stock.edit', compact('productStock'));
    }

    public function update(Request $request, ProductStock $productStock)
    {
        // Update data product stock yang ada
        $productStock->product_id = $request->product_id;
        $productStock->size = $request->size;
        $productStock->stock = $request->stock;
        $productStock->save();

        return redirect()->route('product_stock.index');
    }

    public function destroy(ProductStock $productStock)
    {
        // Hapus data product stock yang ada
        $productStock->delete();

        return redirect()->route('product_stock.index');
    }
}
