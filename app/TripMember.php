<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TripMember extends Pivot
{
    protected $table = 'trip_member';
    protected $fillable = [
        'trip_id' , 'user_id' , 'suggestion'

    ];
}
