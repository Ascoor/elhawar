<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'levels';
    protected $fillable = [
        'name','description'

    ];
    public function playerGroup(){
        return $this->belongsToMany(PlayerGroup::class , 'level_group' , 'level_id' , 'group_id');
    }
    public function sportAcademy(){
        return $this->belongsToMany(SportAcademy::class , 'level_sport' , 'level_id' , 'sport_id');
    }
}
