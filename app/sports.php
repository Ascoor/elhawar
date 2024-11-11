<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sports extends Model
{
    protected $table = 'sports';
    protected $fillable = [
        'name','code','kind'

    ];
    public function sportsTeams(){
        return $this->hasMany(sportsTeams::class , 'team_id' , 'sport_id');
    }
    public function championships(){
        return $this->hasMany(Championships::class , 'championship_id' , 'sport_id');
    }
    public function trainings(){
        return $this->hasMany(TeamsTrainings::class , 'training_id' , 'sport_id');
    }
    public function image_url()
    {
        return ($this->image) ? asset_url('avatar/' . $this->image) : asset('img/default-profile-3.png');
    }
}
