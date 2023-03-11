<?php

namespace App\Models;

use App\Models\Agent;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Provider extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $primaryKey = 'sp_id';

    protected $table = 'service_provider';

    protected $fillable = [
            'user_id',
            'name',
            'phone_number',
            'latitude',
            'longitude',
            'state',
            'business_address',
            'lga',
            'gender',
            'verified_by_agent',
            'type',
            'status',
            'account_number',
            'bank_name',
            'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function approval()
    {
    return $this->hasOne(Approval::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}