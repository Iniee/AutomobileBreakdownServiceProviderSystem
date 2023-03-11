<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breakdown extends Model
{
    use HasFactory;

    protected $table = 'breakdowns';

    protected $primaryKey = 'breakdown_id';

    protected $fillable = [
        'breakdown_id',
        'breakdown_location',
        'destination_location',
        'status'
    ];
}