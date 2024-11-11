<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class memberStatus extends Model
{
    protected $table = 'member_status';
    protected $fillable = [
        'status_name',

    ];
    public function member()
    {
        return $this->hasMany(memberDetails::class, 'status_id' , 'id');
    }
}