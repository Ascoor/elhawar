<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penlatyduraton extends Model
{
    protected $table = 'penalty_days';
    protected $fillable = [
        
        'days',
    ];
}
