<?php

namespace App;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LevelGroup extends Pivot
{
    protected $table = 'level_group';
    protected $fillable = [
        'level_id','group_id',

    ];
}