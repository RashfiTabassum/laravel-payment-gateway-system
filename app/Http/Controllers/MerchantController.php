<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    // LIST
    public function index()
    {
        $merchants = Merchant::latest('id')->paginate(10);
        return view('admin.merchants.index', compact('merchants'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.merchants.create');
    }

    // STORE NEW MERCHANT
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'address'  => ['nullable', 'string'],
        ]);

        // 1) create user row
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'user_type' => User::TYPE_MERCHANT,   // adjust if your column is different
        ]);

        // 2) create merchant profile row
        Merchant::create([
            'user_id'   => $user->id,
            'store_id'  => 'store_' . Str::random(12),
            'name'      => $data['name'],
            'email'     => $data['email'],
            'address'   => $data['address'] ?? null,
            'status'    => 1, // default active
        ]);

        return redirect()
            ->route('merchants.index')
            ->with('ok', 'Merchant created successfully!');
    }

    // EDIT FORM
    public function edit(Merchant $merchant)
    {
        return view('admin.merchants.edit', compact('merchant'));
    }

    // UPDATE MERCHANT
    public function update(Request $request, Merchant $merchant)
    {
        $request->validate([
            'user_id'  => ['required', 'integer'],
            'store_id' => ['required', 'string'],
            'name'     => ['required', 'string', 'max:100'],
            'email'    => [
                'required',
                'email',
                'max:100',
                // email unique in users table but ignore this merchant’s user
                Rule::unique('users', 'email')->ignore($merchant->user_id),
            ],
            'address'  => ['nullable', 'string'],
            'status'   => ['required', 'integer'],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        // update merchant row
        $merchant->update([
            'user_id'  => $request->user_id,
            'store_id' => $request->store_id,
            'name'     => $request->name,
            'email'    => $request->email,
            'address'  => $request->address,
            'status'   => $request->status,
        ]);

        // update linked user row
        $user = User::find($merchant->user_id);

        if ($user) {
            $user->name  = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        return redirect()
            ->route('merchants.index')
            ->with('success', 'Merchant updated successfully.');
    }

    // DELETE MERCHANT
    public function destroy(Merchant $merchant)
    {
        // don't let a merchant delete their *own* user
        if (auth()->id() === $merchant->user_id) {
            return back()->with('err', 'You cannot delete your own account.');
        }

        if (Merchant::count() <= 1) {
            return back()->with('err', 'At least one merchant must remain.');
        }

        // delete user row too (optional, but usually what you want)
        $user = User::find($merchant->user_id);
        if ($user) {
            $user->delete();
        }

        $merchant->delete();

        return back()->with('ok', 'Merchant deleted successfully.');
    }

    // SHOW PAGE
    public function show(Merchant $merchant)
    {
        return view('admin.merchants.show', compact('merchant'));
    }

    // PROFILE (LOGGED-IN MERCHANT)
    public function profile()
    {
        $user = auth()->user();
        return view('merchant.profile', compact('user'));
    }
}
