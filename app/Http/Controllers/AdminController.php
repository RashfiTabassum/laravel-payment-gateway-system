<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
/**
 * @param \Illuminate\Http\Request $request
 * @param \App\Models\Admin $admin
 */



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

        Admin::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'user_type' => Admin::USER_TYPE_ADMIN,
            'status'    => Admin::STATUS_ACTIVE,
        ]);

        return redirect()->route('admins.index')->with('ok', 'Admin created successfully!');
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
        ]);

        $admin->fill([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        if (!empty($data['password'])) {
            $admin->password = Hash::make($data['password']);
        }

        // enforce role & (optionally) keep active
        $admin->user_type = Admin::USER_TYPE_ADMIN;
        // $admin->status    = Admin::STATUS_ACTIVE; // uncomment if you want to force active

        $admin->save();

        return redirect()->route('admins.index')->with('ok', 'Admin updated successfully!');
    }

    public function destroy(Admin $admin)
    {
        // If you haven't configured an 'admin' guard, use auth() instead of auth('admin')
        if (auth()->id() === $admin->id) {
            return back()->with('err', 'You cannot delete your own account.');
        }

        if (Admin::count() <= 1) {
            return back()->with('err', 'At least one admin must remain.');
        }

        $admin->delete();

        return back()->with('ok', 'Admin deleted successfully.');
    }
}
