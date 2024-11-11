<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Trips extends Model
{
    use Rateable;
    protected $dates = ['start_date_time', 'end_date_time'];
    protected $table = 'trips';
    protected $fillable = [
        'trip_name','supervisor_id','program' , 'label_color' , 'repeat' , 'capacity' , 'member_fees' ,'repeat_type' , 'start_time' ,'end_time',
        'repeat_every','repeat_cycles','available','non_member_fees','escort_fees','currency'

    ];
    public function subscribers(){
        return $this->belongsToMany(User::class , 'session_member' , 'trip_id' , 'user_id');
    }
    public function image_url()
    {
        return ($this->image) ? asset_url('avatar/' . $this->image) : asset('img/default-profile-3.png');
    }
}
