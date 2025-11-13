<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pos;
use App\Models\Merchant;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }
}
