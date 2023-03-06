<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundWallet extends Model
{
    use HasFactory;

    protected $table = 'fund_wallets';

    protected $fillable = [
            'client_id',
            'client_name',
            'client_email',
            'paymentstatus',
            'status',
            'transaction_id',
            'transaction_reference',
            'charged_amount',
            'processor_response'
    ];

     public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }
}