<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SportAcademy extends Model
{
    protected $table = 'sport_academies';
    protected $fillable = [
        'name','code','description'
    ];
    public function level(){
        return $this->belongsToMany(Level::class , 'level_sport' , 'sport_id' , 'level_id');
    }
    public function locations(){
        return $this->belongsToMany(Location::class , 'sport_location' , 'sport_id' , 'location_id')
            ->withPivot('level_id' , 'group_id' , 'coach_id' , 'capacity' , 'fees' ,'training_days' , 'start_time' ,'end_time');
    }
    public function image_url()
    {
        return ($this->image) ? asset_url('avatar/' . $this->image) : asset('img/default-profile-3.png');
    }

}
