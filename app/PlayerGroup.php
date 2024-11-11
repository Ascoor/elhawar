<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerGroup extends Model
{
    protected $table = 'player_groups';
    protected $fillable = [
        'name',

    ];
    public function level(){
        return $this->belongsToMany(Level::class , 'level_group' , 'group_id' , 'level_id');
    }
}
