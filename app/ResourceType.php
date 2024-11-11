<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    //
    public function resource(){
        $this->hasMany(Resource::class);
    }
}
