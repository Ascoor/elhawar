<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PenaltyUser extends Pivot
{
    protected $table = 'penalty_user';
    protected $fillable = [
        'penalty_id' , 'user_id'

    ];
}
