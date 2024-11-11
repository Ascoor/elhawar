<?php

namespace Modules\Accounting\Entities;
use Illuminate\Database\Eloquent\Model;

class AccountingSetting extends Model
{

    protected $table = 'accounting_settings';

    protected $fillable=['capital'];
    


}
