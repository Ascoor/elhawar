<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    protected $table='letters_of_guarantee_types';

    public $appends = [
        'name',
     ];

    ////////////////-----------------------------////////////////

    public function getnameAttribute()
    {   
        if(app()->getLocale()=='ar')
        {
            return $this->name_ar;
        }
            
        return $this->name_en;
    }

    ////////////////-----------------------------////////////////


}
