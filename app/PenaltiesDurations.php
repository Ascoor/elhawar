<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenaltiesDurations extends Model
{
    protected $table = 'penalty_days';
    protected $fillable = [
        
        'days',
    ];
}
