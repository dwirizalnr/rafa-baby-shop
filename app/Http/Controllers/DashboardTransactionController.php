<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $buyTransactions = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->whereHas('transaction', function ($transaction) {
                $transaction->where('users_id', Auth::user()->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.dashboard-transactions', ['buyTransactions' => $buyTransactions]);
    }
    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->findOrFail($id);
             // ambil data provinsi berdasarkan id
        $province = Province::find($transaction->transaction->user->province_id);
        // ambil data kota berdasarkan id
        $city = City::find($transaction->transaction->user->city_id);

        $transaction->province = $transaction->transaction->user->name; // set nama provinsi
        $transaction->city = $transaction->transaction->user->name; // set nama kota
           
        return view('pages.dashboard-transactions-details', [
            'transaction' => $transaction
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findOrFail($id);

        $item->update($data);

        return redirect()->route('dashboard-transaction-details', $id);
    }

    public function account()
    {
        $user = Auth::user();
        // Memanggil function get_province
        $provinsi = $this->get_province();

        return view('pages.dashboard-account', [
            'user' => $user, 'provinsi' => $provinsi,
        ]);
    }
}
