<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function clientTransaction () 
    {
        return view('content.transaction.client');
    }

    public function serviceCharges () 
    {
        return view('content.transaction.service');
    }
}