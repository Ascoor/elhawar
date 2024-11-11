<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralAssembly extends Model
{
    protected $table = 'general_assemblies';
    protected $fillable = [
        'name','start_date','delay_fine','currency'

    ];
    public function attendees(){
        return $this->belongsToMany(User::class , 'assembly_attendees' , 'assembly_id' , 'user_id');
    }
}
