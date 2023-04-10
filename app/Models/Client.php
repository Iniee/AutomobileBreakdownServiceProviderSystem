<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Client extends  Authenticatable
{
    use HasFactory, HasApiTokens,Notifiable;



    protected $table = 'clients';

    protected $primaryKey = 'client_id';



    protected $fillable = [ 
        'user_id',
        'name',
        'gender',
        'phone_number',
        'city',
        'state',
        'home_address',
        'latitude',
        'longitude',
        'profile_picture'
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

    public function breakdowns()
    {
        return $this->hasMany(Breakdown::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class, 'client_id');
    }

}