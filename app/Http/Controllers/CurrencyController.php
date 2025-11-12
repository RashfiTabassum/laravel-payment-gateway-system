<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'code' => 'required|string|max:10',
        ]);

        // Currency::create($request->all());

        // return redirect()->route('currencies.index')->with('success', 'Currency added successfully!');
         try {
        Currency::create($request->all());
        return redirect()->route('currencies.index')
                         ->with('message', 'Currency added successfully!')
                         ->with('alert-type', 'success');
    } catch (\Exception $e) {
        return redirect()->back()
                         ->with('message', 'Failed to add currency.')
                         ->with('alert-type', 'danger');
    }
    }

    public function show(Currency $currency)
    {
        return view('admin.currencies.show', compact('currency'));
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'code' => 'required|string|max:10',
        ]);

        // $currency->update($request->all());

        // return redirect()->route('currencies.index')->with('success', 'Currency updated successfully!');
        try {
        $currency->update($request->all());
        return redirect()->route('currencies.index')
                         ->with('message', 'Currency updated successfully!')
                         ->with('alert-type', 'success');
    } catch (\Exception $e) {
        return redirect()->back()
                         ->with('message', 'Failed to update currency.')
                         ->with('alert-type', 'danger');
    }
    }

    public function destroy(Currency $currency)
    {
        // $currency->delete();
        // return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully!');
        try {
        $currency->delete();
        return redirect()->route('currencies.index')
                         ->with('message', 'Currency deleted successfully!')
                         ->with('alert-type', 'success');
            } catch (\Exception $e) {
                return redirect()->back()
                                ->with('message', 'Failed to delete currency.')
                                ->with('alert-type', 'danger');
            }
    }
}