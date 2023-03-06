<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $primaryKey = 'feedback_id';

    protected $table = 'feedbacks';

    protected $fillable = [
        'review',
        'star_rating',
    ];

}
