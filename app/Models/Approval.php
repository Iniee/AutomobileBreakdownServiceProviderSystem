<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $table = 'approvals';
    

    protected $fillable = [
        'document',
        'address_confirmation',
        'plate_number', 
        'provider_id',
        'agent_id',
        'status'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
    

}