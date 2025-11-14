<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        /** @var \Illuminate\Http\Request $request */
        $request->validate([
            'name'          => 'required|string|max:255',
            'issuer_name'   => 'required|string|max:255',
            'api_url'       => 'required|string|max:255',
            'user_name'     => 'required|string|max:255',
            'user_password' => 'required|string|max:255',
            'status'        => 'required|in:0,1',
            'code'          => 'required|string|max:50|unique:banks,code',
            'branch'        => 'required|string|max:255',
        ]);

        try {
            Bank::create($request->all());

            return redirect()->route('admin.banks.index')
                             ->with('message', 'Bank added successfully!')
                             ->with('alert-type', 'success');
        } catch (QueryException $e) {
            return back()
                ->with('message', 'Failed to add bank. Duplicate data might exist.')
                ->with('alert-type', 'danger');
        } catch (\Exception $e) {
            return back()
                ->with('message', 'Failed to add bank.')
                ->with('alert-type', 'danger');
        }
    }

    public function show(Bank $bank)
    {
        return view('admin.banks.show', compact('bank'));
    }

    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {   /** @var \App\Models\Bank $bank */

        /** @var \Illuminate\Http\Request $request */
        $request->validate([
            'name'          => 'required|string|max:255',
            'issuer_name'   => 'required|string|max:255',
            'api_url'       => 'required|string|max:255',
            'user_name'     => 'required|string|max:255',
            'user_password' => 'required|string|max:255',
            'status'        => 'required|in:0,1',
            'code'          => 'required|string|max:50|unique:banks,code,' . $bank->id,
            'branch'        => 'required|string|max:255',
        ]);

        try {
            $bank->update($request->all());

            return redirect()->route('admin.banks.index')
                ->with('message', 'Bank updated successfully!')
                ->with('alert-type', 'success');
        } catch (QueryException $e) {
            return back()
                ->with('message', 'Failed to update bank. Duplicate data not allowed.')
                ->with('alert-type', 'danger');
        } catch (\Exception $e) {
            return back()
                ->with('message', 'Failed to update bank.')
                ->with('alert-type', 'danger');
        }
    }

    public function destroy(Bank $bank)
    {   /** @var \App\Models\Bank $bank */

        try {
            $bank->delete();

            return redirect()->route('admin.banks.index')
                ->with('message', 'Bank deleted successfully!')
                ->with('alert-type', 'success');
        } catch (\Exception $e) {
            return back()
                ->with('message', 'Failed to delete bank.')
                ->with('alert-type', 'danger');
        }
    }
}
