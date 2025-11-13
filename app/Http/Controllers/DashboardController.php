<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->user_type == 1) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->user_type == 2) {
            return redirect()->route('merchant.dashboard');
        }

        abort(403, 'Unauthorized access');
    }

    public function adminDashboard()
    {
        return view('admin.home');
    }

    public function merchantDashboard()
    {
        return view('merchant.home');
    }
}
