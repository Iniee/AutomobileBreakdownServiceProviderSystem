<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnosis extends Model
{
    use HasFactory;


    protected $table = 'diagnoses';

    protected $fillable = [
        'description',
        'cost',
        'provider_id',
        'client_id',
        'breakdown_id'
    ];

      public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}