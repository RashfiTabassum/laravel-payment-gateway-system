<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Show all transactions for the logged-in merchant
    public function index()
    {
        $merchant = Auth::user()->merchant;
        $transactions = Transaction::where('merchant_id', $merchant->id)
            ->latest()
            ->get();

        return view('merchant.transactions.index', compact('transactions'));
    }

    // View single transaction
    public function show(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);
        return view('merchant.transactions.show', compact('transaction'));
    }

    // Update transaction status (Pending → Refunded, Completed, etc.)
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        $validated = $request->validate([
            'transaction_state' => 'required|in:Completed,Pending,Refunded,Partial Refunded,Failed'
        ]);

        $transaction->transaction_state = $validated['transaction_state'];
        $transaction->save();

        return redirect()->route('merchant.transactions.index')
                 ->with('success', 'Transaction status updated successfully.');

    }

    // Ensure the logged-in merchant owns the transaction
    private function authorizeAccess(Transaction $transaction)
    {
        $merchant = Auth::user()->merchant;
        if ($transaction->merchant_id !== $merchant->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
