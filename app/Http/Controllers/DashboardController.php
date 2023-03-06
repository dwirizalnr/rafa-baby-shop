<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        //transaction
        $transactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
        ->whereHas('transaction', function ($transaction) {
            $transaction->where('users_id', Auth::user()->id)
                        ->where('transaction_status', '!=', 'success');
        })
    ->orderBy('created_at', 'DESC');

    //shipping process
    $shipping_status = TransactionDetail::with(['transaction.user', 'product.galleries'])
    ->whereHas('transaction', function ($transaction) {
        $transaction->where('users_id', Auth::user()->id);
                    
    })
    ->whereNotIn('shipping_status', ['shipping'])
    ->orderBy('created_at', 'DESC');

    $shipping = TransactionDetail::with(['transaction.user', 'product.galleries'])
    ->whereHas('transaction', function ($transaction) {
        $transaction->where('users_id', Auth::user()->id);
                    
    })
    ->whereNotIn('shipping_status', ['process'])
    ->orderBy('created_at', 'DESC');

    $revenue = $transactions->get()->reduce(function ($carry, $item) {
    return $carry + $item->price;
});

return view('pages.dashboard', [
    'transaction_data' => $transactions->get(),
    'shipping_status' => $shipping_status->get(),
    'shipping' => $shipping->get()
]);
    }
}
