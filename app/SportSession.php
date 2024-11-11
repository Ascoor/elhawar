<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SportSession extends Pivot
{
    protected $dates = ['start_date_time', 'end_date_time'];
    protected $table = 'sport_location';
    protected $fillable = [
        'location_id','sport_id','level_id' , 'group_id' , 'coach_id' , 'capacity' , 'fees' ,'training_days' , 'start_time' ,'end_time'

    ];
    public function subscribers(){
        return $this->belongsToMany(User::class , 'session_member' , 'session_id' , 'user_id');
//            ->withPivot('level_id' , 'group_id' , 'coach_id' , 'capacity' , 'fees' ,'training_days' , 'start_time' ,'end_time');
    }
}