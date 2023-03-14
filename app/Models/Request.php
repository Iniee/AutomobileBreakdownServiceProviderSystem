<?php

namespace App\Models;

use App\Models\Provider;
use App\Models\Breakdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{
    use HasFactory;
    
    protected $table = 'requests';

    protected $fillable = [
        'breakdown_id', 
        'provider_id',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
     public function breakdown()
    {
        return $this->belongsTo(Breakdown::class);
    }
}