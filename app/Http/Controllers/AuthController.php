<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private function redirectToDashboard(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isMerchant()) {
            return redirect()->route('merchant.dashboard');
        }

        abort(403, 'Unauthorized user type.');
    }


    public function showLogin() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // block passive users
            if (auth()->user()->status != 1) {
                Auth::logout();
                return back()->withErrors(['email'=>'Your account is not active.'])->onlyInput('email');
            }
            $user = Auth::user();
            return $this->redirectToDashboard($user);
        }

        return back()->withErrors(['email'=>'Invalid credentials'])->onlyInput('email');
    }

    public function showRegister() {
        return view('admin.auth.register');
    }

    public function register(Request $request) {
        $data = $request->validate([
            'name'       => ['required','string','max:100'],
            'email'      => ['required','email','max:100','unique:users,email'],
            'password'   => ['required','string','min:6','confirmed'],
            'user_type' => ['required', 'in:' . User::TYPE_ADMIN . ',' . User::TYPE_MERCHANT],

        ]);

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'user_type' => (int)$data['user_type'],
            'status'    => 1,
        ]);

        Auth::login($user);

        return $this->redirectToDashboard($user);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
