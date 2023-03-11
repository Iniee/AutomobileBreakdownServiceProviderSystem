<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Agent extends Authenticatable
{
    use HasFactory, HasApiTokens,Notifiable;

    protected $primaryKey = 'agent_id';

    protected $table = 'agents';

    protected $fillable = [
            'user_id',
            'name',
            'phone_number',
            'home_address',
            'latitude',
            'longitude',
            'state',
            'lga',
            'gender',
            'status',
            'account_number',
            'bank_name',
            'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function user () {
        return $this->belongsTo(User::class);
    }

}