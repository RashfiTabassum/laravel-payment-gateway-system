<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Exception;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::latest('id')->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        try {
            Admin::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
                'user_type' => Admin::USER_TYPE_ADMIN,
                'status'    => Admin::STATUS_ACTIVE,
            ]);

            return redirect()
                ->route('admins.index')
                ->with('message', 'Admin created successfully!')
                ->with('alert-type', 'success');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('message', $e->getMessage())
                ->with('alert-type', 'danger');
        }
    }

    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => [
                'required', 'email', 'max:100',
                Rule::unique('users', 'email')->ignore($admin->id),
            ],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'status'   => ['nullable'],
        ]);

        try {
            $admin->name  = $data['name'];
            $admin->email = $data['email'];

            if (!empty($data['password'])) {
                $admin->password = Hash::make($data['password']);
            }

            $admin->user_type = Admin::USER_TYPE_ADMIN;
            $admin->status = $request->boolean('status');

            $admin->save();

            return redirect()
                ->route('admins.index')
                ->with('message', 'Admin updated successfully!')
                ->with('alert-type', 'success');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('message', $e->getMessage())
                ->with('alert-type', 'danger');
        }
    }

    public function destroy(Admin $admin)
    {
        try {
            if (auth()->id() === $admin->id) {
                return back()
                    ->with('message', 'You cannot delete your own account.')
                    ->with('alert-type', 'danger');
            }

            if (Admin::count() <= 1) {
                return back()
                    ->with('message', 'At least one admin must remain.')
                    ->with('alert-type', 'danger');
            }

            $admin->delete();

            return back()
                ->with('message', 'Admin deleted successfully.')
                ->with('alert-type', 'success');

        } catch (Exception $e) {
            return back()
                ->with('message', $e->getMessage())
                ->with('alert-type', 'danger');
        }
    }
}
