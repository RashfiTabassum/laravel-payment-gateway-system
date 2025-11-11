<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    // Show all currencies
    public function index()
    {
        $currencies = Currency::latest()->paginate(10);
        return view('admin.currencies.index', compact('currencies'));
    }

    // Show create form
    public function create()
    {
        return view('admin.currencies.create');
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

        return redirect()->route('currencies.index')->with('success', 'Currency added successfully.');
    }

    // Show single currency
    public function show(Currency $currency)
    {
        return view('admin.currencies.show', compact('currency'));
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
