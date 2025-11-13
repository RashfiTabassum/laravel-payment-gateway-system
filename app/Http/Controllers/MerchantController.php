<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = Merchant::latest('id')->paginate(10);
        return view('admin.merchants.index', compact('merchants'));
    }

    public function create()
    {
        return view('admin.merchants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            // ✅ validate against users table
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        Merchant::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password' => $data['password'],
            'user_type' => User::TYPE_MERCHANT,   // make sure it’s an admin row
            // 'status'  => 1,   // if you use a status column
        ]);

        return redirect()->route('merchants.index')->with('ok', 'Merchant created successfully!');
    }

    public function edit(Merchant $merchant)
    {
        return view('admin.merchants.edit', compact('merchant'));
    }

    public function update(Request $request, Merchant $merchant)
    {
        $data = $request->validate([
            // ✅ no unique rule on name
            'name'  => ['required', 'string', 'max:100'],
            // ✅ unique on users table; ignore current admin row
            'email' => [
                'required', 'email', 'max:100',
                Rule::unique('users', 'email')->ignore($merchant->id),
            ],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $merchant->fill([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        if (!empty($data['password'])) {
            $merchant->password = Hash::make($data['password']);
        }

        // keep it an admin (in case someone changed this field elsewhere)
        $merchant->user_type = User::TYPE_MERCHANT;

        $merchant->save();

        return redirect()->route('merchants.index')->with('ok', 'Merchant updated successfully!');
    }

    public function destroy(Merchant $merchant)
    {
        if (auth()->id() === $merchant->id) {
            return back()->with('err', 'You cannot delete your own account.');
        }

        // Admin::count() is already scoped to user_type=1 if your Admin model has that scope
        if (Merchant::count() <= 1) {
            return back()->with('err', 'At least one merchant must remain.');
        }

        $merchant->delete();

        return back()->with('ok', 'Merchant deleted successfully.');
    }

    //show method
    public function show(Merchant $merchant)
    {
        return view('admin.merchants.show', compact('merchant')); //
    }
    
    public function profile()
    {
        $user = auth()->user();
        return view('merchant.profile', compact('user'));
    }

}
