<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembersOrder extends Model
{
    //
    public function getFileAttribute($file){
        return asset($file);
    }
}
