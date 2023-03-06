<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    
    use HasFactory, HasApiTokens,Notifiable;
    
    protected $primaryKey = 'admin_id';

    protected $table = 'admins';

    protected $fillable = ['first_name', 'user_id', 'last_name','gender', 'account_number','bank_name'];

   
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

}