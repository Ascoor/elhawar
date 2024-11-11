<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cases extends BaseModel
{
    protected $table = 'cases';
    protected $fillable = [
        'case_name','case_id','details' , 'lawyers' , 'opponents'

    ];
}
