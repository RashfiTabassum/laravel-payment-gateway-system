<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\User;
use App\Models\Pos;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->user_type === 1) {
            return view('admin.home');
        }

        // return view('admin.merchants.home');
    }
    public function dashboard(Request $request)
    {
        // Determine which tab is selected (default: banks)
        $tab = $request->query('tab');
 
        // Counts for sidebar
        $counts = [
            'banks'        => Bank::count(),
            'currencies'   => Currency::count()
            // 'merchants'    => Merchant::count(),
            // 'transactions' => Transaction::count(),
            // 'pos'          => Pos::count(),
        ];
 
        // Load only data for the active tab
        $banks = $merchants = $transactions = $pos = collect();
 
        if ($tab === 'banks') {
            $banks = Bank::latest('id')->paginate(10, ['*'], 'banks');
        } else if ($tab === 'currencies') {
            $banks = Bank::latest('id')->paginate(10, ['*'], 'currencies');
        } 
        // elseif ($tab === 'merchants') {
        //     $merchants = Merchant::latest('id')->paginate(10, ['*'], 'merchants');
        // } elseif ($tab === 'pos') {
        //     $pos = Pos::latest('id')->paginate(10, ['*'], 'pos');
        // } elseif ($tab === 'transactions') {
        //     $transactions = Transaction::with(['merchant', 'bank', 'pos', 'currency'])
        //         ->latest('id')
        //         ->paginate(10, ['*'], 'transactions');
        // }
 
        // Send data to the view
        return view('admin.home');
    }
}
