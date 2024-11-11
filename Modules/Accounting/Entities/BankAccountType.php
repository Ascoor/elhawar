<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class BankAccountType extends Model
{
    protected $table='bank_account_types';

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
