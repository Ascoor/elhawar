<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penalties extends BaseModel
{
    protected $table = 'penalties';
    protected $fillable = [
        'user_id','penalty_name','details' , 'amount' , 'currency'

    ];

    //rola
    // protected $fillable = array(
    //     'user_id','penalty_name','details' , 'amount' , 'currency'
    // );
    public function users(){
        return $this->belongsToMany(User::class , 'penalty_user' , 'penalty_id' , 'user_id');
    }
}
