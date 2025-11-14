<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

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
        /** @var \Illuminate\Http\Request $request */
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'address'  => ['nullable', 'string'],
        ]);

        try {
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
                ->with('message', 'Merchant created successfully!')
                ->with('alert-type', 'success');

        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('message', 'Failed to create merchant. Duplicate data might exist.')
                ->with('alert-type', 'danger');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('message', 'Failed to create merchant.')
                ->with('alert-type', 'danger');
        }
    }

    // EDIT FORM
    public function edit(Merchant $merchant)
    {
        return view('admin.merchants.edit', compact('merchant'));
    }

    // UPDATE MERCHANT
    public function update(Request $request, Merchant $merchant)
    {
        /** @var \Illuminate\Http\Request $request */

        $data = $request->validate([
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

        try {
            // update merchant row
            $merchant->update([
                'user_id'  => $data['user_id'],
                'store_id' => $data['store_id'],
                'name'     => $data['name'],
                'email'    => $data['email'],
                'address'  => $data['address'] ?? null,
                'status'   => $data['status'],
            ]);

            // update linked user row
            $user = User::find($merchant->user_id);

            if ($user) {
                $user->name  = $data['name'];
                $user->email = $data['email'];

                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                }

                $user->save();
            }

            return redirect()
                ->route('merchants.index')
                ->with('message', 'Merchant updated successfully.')
                ->with('alert-type', 'success');

        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('message', 'Failed to update merchant. Duplicate data not allowed.')
                ->with('alert-type', 'danger');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('message', 'Failed to update merchant.')
                ->with('alert-type', 'danger');
        }
    }

    // DELETE MERCHANT
    public function destroy(Merchant $merchant)
    {
        try {
            // don't let a merchant delete their *own* user
            if (auth()->id() === $merchant->user_id) {
                return back()
                    ->with('message', 'You cannot delete your own account.')
                    ->with('alert-type', 'danger');
            }

            if (Merchant::count() <= 1) {
                return back()
                    ->with('message', 'At least one merchant must remain.')
                    ->with('alert-type', 'danger');
            }

            // delete user row too (optional, but usually what you want)
            $user = User::find($merchant->user_id);
            if ($user) {
                $user->delete();
            }

            $merchant->delete();

            return back()
                ->with('message', 'Merchant deleted successfully.')
                ->with('alert-type', 'success');

        } catch (\Exception $e) {
            return back()
                ->with('message', 'Failed to delete merchant.')
                ->with('alert-type', 'danger');
        }
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
