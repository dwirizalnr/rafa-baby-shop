<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User as ModelsUser;

use Illuminate\Http\Request;

use Appp\User;
use Illuminate\Foundation\Auth\User as AuthUser;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = AuthUser::count();
        $revenue = Transaction::sum('total_price');
        $transaction = Transaction::count();

        return view('pages.admin.dashboard', [
            'customer' => $customer,
            'revenue' => $revenue,
            'transaction' => $transaction
        ]);
    }
}
