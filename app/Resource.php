<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    //
    public function resourceType (){
       return $this->belongsTo(ResourceType::class ,'type');
    }
}
