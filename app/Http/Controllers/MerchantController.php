<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Exception;

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
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'address'  => ['nullable', 'string'],
        ]);

        try {
            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
                'user_type' => User::TYPE_MERCHANT,
            ]);

            Merchant::create([
                'user_id'   => $user->id,
                'store_id'  => 'store_' . Str::random(12),
                'name'      => $data['name'],
                'email'     => $data['email'],
                'address'   => $data['address'] ?? null,
                'status'    => 1,
            ]);

            return redirect()
                ->route('merchants.index')
                ->with('message', 'Merchant created successfully!')
                ->with('alert-type', 'success');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('message', $e->getMessage())
                ->with('alert-type', 'danger');
        }
    }

    public function edit(Merchant $merchant)
    {
        return view('admin.merchants.edit', compact('merchant'));
    }

    public function update(Request $request, Merchant $merchant)
    {
        $data = $request->validate([
            'user_id'  => ['required', 'integer'],
            'store_id' => ['required', 'string'],
            'name'     => ['required', 'string', 'max:100'],
            'email'    => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($merchant->user_id),
            ],
            'address'  => ['nullable', 'string'],
            'status'   => ['required', 'integer'],
            'password' => ['nullable', 'confirmed', 'min:6'],
        ]);

        try {
            $merchant->update([
                'user_id'  => $data['user_id'],
                'store_id' => $data['store_id'],
                'name'     => $data['name'],
                'email'    => $data['email'],
                'address'  => $data['address'] ?? null,
                'status'   => $data['status'],
            ]);

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
                ->with('message', 'Merchant updated successfully!')
                ->with('alert-type', 'success');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('message', $e->getMessage())
                ->with('alert-type', 'danger');
        }
    }

    public function destroy(Merchant $merchant)
    {
        try {
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

            $user = User::find($merchant->user_id);
            if ($user) $user->delete();

            $merchant->delete();

            return back()
                ->with('message', 'Merchant deleted successfully.')
                ->with('alert-type', 'success');

        } catch (Exception $e) {
            return back()
                ->with('message', $e->getMessage())
                ->with('alert-type', 'danger');
        }
    }

    public function show(Merchant $merchant)
    {
        return view('admin.merchants.show', compact('merchant'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('merchant.profile', compact('user'));
    }
}
