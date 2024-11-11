<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AssemblyAttendees extends Pivot
{
    protected $table = 'assembly_attendees';
    protected $fillable = [
        'assembly_id' , 'user_id'

    ];
}
