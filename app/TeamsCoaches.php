<?php

namespace App;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamsCoaches extends Pivot
{
    protected $table = 'teams_coaches';
    protected $fillable = [
        'team_id','coach_id',

    ];
}