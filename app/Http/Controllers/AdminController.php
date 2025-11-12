<?php
 
namespace App\Http\Controllers;
 
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
 
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
            // ✅ validate against users table
            'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
 
        Admin::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'user_type' => 1,   // make sure it’s an admin row
            // 'status'  => 1,   // if you use a status column
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
            // ✅ no unique rule on name
            'name'  => ['required', 'string', 'max:100'],
            // ✅ unique on users table; ignore current admin row
            'email' => [
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
 
        // keep it an admin (in case someone changed this field elsewhere)
        $admin->user_type = 1;
 
        $admin->save();
 
        return redirect()->route('admins.index')->with('ok', 'Admin updated successfully!');
    }
 
    public function destroy(Admin $admin)
    {
        if (auth('admin')->id() === $admin->id) {
            return back()->with('err', 'You cannot delete your own account.');
        }
 
        // Admin::count() is already scoped to user_type=1 if your Admin model has that scope
        if (Admin::count() <= 1) {
            return back()->with('err', 'At least one admin must remain.');
        }
 
        $admin->delete();
 
        return back()->with('ok', 'Admin deleted successfully.');
    }

    //show method
    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin')); //
    }
}
 