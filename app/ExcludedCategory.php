<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExcludedCategory extends Model
{
    protected $table = 'excluded_categories';
    protected $fillable =
        [
            'name',
        ];
}
