<?php

namespace App\Http\Controllers;

use App\Models\Currency; //Currency model (interacts with the currencies database table)
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    // Show all currencies
    public function index()   
    {
        $currencies = Currency::latest()->paginate(10); //Fetch latest currencies with pagination. page size 10
        return view('admin.currencies.index', compact('currencies')); //Sends them to the admin/currencies/index.blade.php view.
    }

    // Show create form
    public function create()
    {
        return view('admin.currencies.create'); //Returns the view for creating a new currency.
    }

    // Store new currency
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:100',
            'symbol' => 'required|string|max:10',
            'code'   => 'required|string|max:10',
        ]);

        Currency::create($data);

        return redirect()->route('currencies.index')->with('success', 'Currency added successfully.');//Redirects to the currencies index with a success message.
    }

    // Show single currency
    public function show(Currency $currency)
    {
        return view('admin.currencies.show', compact('currency')); //Returns the view for showing a single currency. compact passes the currency to the view. compact('currency') is equivalent to ['currency' => $currency].
    }

    // Show edit form
    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    // Update currency
    public function update(Request $request, Currency $currency)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:100',
            'symbol' => 'required|string|max:10',
            'code'   => 'required|string|max:10',
        ]);

        $currency->update($data);

        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    // Delete currency
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
