<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
        // Validate input including uniqueness
        $request->validate([
            'name'   => 'required|string|max:255|unique:currencies,name',
            'symbol' => 'required|string|max:10|unique:currencies,symbol',
            'code'   => 'required|string|max:10|unique:currencies,code',
        ]);

        try {
            Currency::create($request->all());

            return redirect()->route('currencies.index')
                             ->with('message', 'Currency added successfully!')
                             ->with('alert-type', 'success');

        } catch (QueryException $e) {
            // Handle database errors like duplicates
            return redirect()->back()
                             ->with('message', 'Failed to add currency. It might already exist.')
                             ->with('alert-type', 'danger');
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
        // Validate input including uniqueness, ignoring current record
        $request->validate([
            'name'   => 'required|string|max:255|unique:currencies,name,' . $currency->id,
            'symbol' => 'required|string|max:10|unique:currencies,symbol,' . $currency->id,
            'code'   => 'required|string|max:10|unique:currencies,code,' . $currency->id,
        ]);

        try {
            $currency->update($request->all());

            return redirect()->route('currencies.index')
                             ->with('message', 'Currency updated successfully!')
                             ->with('alert-type', 'success');

        } catch (QueryException $e) {
            return redirect()->back()
                             ->with('message', 'Failed to update currency. Duplicate data not allowed.')
                             ->with('alert-type', 'danger');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('message', 'Failed to update currency.')
                             ->with('alert-type', 'danger');
        }
    }

    public function destroy(Currency $currency)
    {
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
