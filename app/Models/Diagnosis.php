<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}