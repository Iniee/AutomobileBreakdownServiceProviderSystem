<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use App\Models\FundWallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function clientTransaction () 
    {
        $transactions = FundWallet::where('processor_response', 'Successful')->latest('created_at')->paginate(12);
        return view('content.transaction.client', compact('transactions'));
    }

    public function serviceCharges () 
    {
        $transactions = Diagnosis::with('client', 'provider')->latest('created_at')->paginate(12);
        return view('content.transaction.service', compact('transactions'));
    }
}