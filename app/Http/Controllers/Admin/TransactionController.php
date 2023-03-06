<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundWallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function clientTransaction () 
    {
        $transactions = FundWallet::latest('created_at')->paginate(12);
        return view('content.transaction.client', compact('transactions'));
    }

    public function serviceCharges () 
    {
        return view('content.transaction.service');
    }
}