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

   public function clients()
    {
        return $this->belongsTo(Client::class, 'breakdown_id', 'client_id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'breakdown_id', 'breakdown_id');
    }
}