<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Championships extends Model
{
    protected $table = 'championships';
    protected $dates = ['start_date_time', 'end_date_time'];
    protected $fillable = [
        'championship_name','sport_id','sport_type','championship_type' ,'team_id' ,'location_id'

    ];
    public function sports()
    {
        return $this->belongsTo(sports::class, 'sport_id');
    }
    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function teams()
    {
        return $this->belongsTo(sportsTeams::class, 'team_id');
    }
}