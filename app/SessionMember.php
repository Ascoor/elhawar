<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SessionMember  extends Pivot
{
    protected $table = 'session_member';
    protected $fillable = [
        'session_id' , 'user_id'

    ];
}