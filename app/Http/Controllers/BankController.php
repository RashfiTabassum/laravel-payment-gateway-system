<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::latest('id')->paginate(10, ['*'], 'banks');
        return view('admin.banks.index', compact('banks'));
        
    }
}
