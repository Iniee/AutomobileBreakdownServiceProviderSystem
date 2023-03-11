<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    
    protected $table = 'requests';

    protected $fillable = [
        'breakdown_id', 
        'provider_id',
    ];
}