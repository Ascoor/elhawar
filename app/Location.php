<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = [
        'name','capacity','description'

    ];
    public function sportAcademy(){
        return $this->belongsToMany(SportAcademy::class , 'sport_location' , 'location_id' , 'sport_id')
            ->withPivot('level_id' , 'group_id' , 'coach_id' , 'capacity' , 'fees' ,'training_days' , 'start_time' ,'end_time');
    }
    public function championships(){
        return $this->hasMany(Championships::class , 'championship_id' , 'location_id');
    }
    public function trainings(){
        return $this->hasMany(TeamsTrainings::class , 'training_id' , 'location_id');
    }
}
