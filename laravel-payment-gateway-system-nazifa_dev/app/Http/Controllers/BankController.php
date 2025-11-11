<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::orderBy('id','DESC')->get();
        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string',
            'issuer_name'  => 'required|string',
            'api_url'      => 'required|string',
            'user_name'    => 'required|string',
            'user_password'=> 'required|string',
            'status'        => 'required|in:1,0',
            'code'         => 'required|string',
            'branch'       => 'required|string',
        ]);

        Bank::create($request->all());

        return redirect()->route('admin.banks.index')->with('success', 'Bank created');
    }

    public function show($id)
    {
        $bank = Bank::findOrFail($id);
        return view('admin.banks.show', compact('bank'));
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $request->validate([
            'name'         => 'required|string',
            'issuer_name'  => 'required|string',
            'api_url'      => 'required|string',
            'user_name'    => 'required|string',
            'user_password'=> 'required|string',
            'status'        => 'required|in:1,0',
            'code'         => 'required|string',
            'branch'       => 'required|string',
        ]);

        $bank->update($request->all());

        return redirect()->route('admin.banks.index')->with('success', 'Bank updated');
    }

    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return redirect()->route('admin.banks.index')->with('success', 'Bank deleted');
    }
}
