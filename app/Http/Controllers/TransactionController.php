<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Pos;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Show all transactions for the logged-in merchant
    public function index()
    {
        $merchant = Auth::user()->merchant;
        $transactions = Transaction::where('merchant_id', $merchant->id)->latest()->get();

        return view('merchant.transactions.index', compact('transactions'));
    }

    // Show create form
    public function create()
    {
        $merchant = Auth::user()->merchant;
        $posList = Pos::active()->get();
        $currencies = Currency::all();

        return view('merchant.transactions.create', compact('posList', 'currencies'));
    }

    // Store new transaction
    public function store(Request $request)
    {
        $merchant = Auth::user()->merchant;

        $validated = $request->validate([
            'invoice_id' => 'required|string',
            'order_id' => 'required|string',
            'transaction_state' => 'required|in:Completed,Pending,Refunded,Partial Refunded,Failed',
            'gross' => 'required|numeric|min:0',
            'net' => 'required|numeric|min:0',
            'fee' => 'nullable|numeric|min:0',
            'pos_id' => 'required|exists:pos,id',
            'currency_id' => 'required|exists:currencies,id',
            'settlement_date' => 'nullable|date',
        ]);

        $validated['merchant_id'] = $merchant->id;

        Transaction::create($validated);

        return redirect()->route('merchant.transactions.index')->with('success', 'Transaction created successfully!');
    }

    // View single transaction
    public function show(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);
        return view('merchant.transactions.show', compact('transaction'));
    }

    private function authorizeAccess(Transaction $transaction)
    {
        $merchant = Auth::user()->merchant;
        if ($transaction->merchant_id !== $merchant->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
