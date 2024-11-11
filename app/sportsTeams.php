<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sportsTeams extends Model
{
    protected $table = 'sports_teams';
    protected $fillable = [
        'team_name','sport_id','from_age','to_age'

    ];

    public function coaches(){
        return $this->belongsToMany(EmployeeDetails::class , 'teams_coaches' , 'team_id' , 'coach_id');
    }
    public function players(){
        return $this->hasMany(User::class , 'player_id' , 'team_id');
    }
    public function sports()
    {
        return $this->belongsTo(sports::class, 'sport_id');
    }
    public function championships(){
        return $this->hasMany(Championships::class , 'championship_id' , 'team_id');
    }
    public function trainings(){
        return $this->hasMany(TeamsTrainings::class , 'training_id' , 'team_id');
    }
}
