<?php

namespace App\Models;

use App\Models\Request;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}