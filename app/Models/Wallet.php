<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $table = 'wallets';
    protected $fillable = [
        'wallet_number', 'wallet_balance',
    ];

    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }
}