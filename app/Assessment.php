<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = 'assessments';
    protected $fillable = [
        'name','player_id','injuries','injuries_effect','physical_assessment','skills_assessment','at_date'

    ];
    public function players()
    {
        return $this->belongsTo(User::class, 'player_id' , 'assess_id');
    }
}
