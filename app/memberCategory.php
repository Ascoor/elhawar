<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class memberCategory extends Model
{
    protected $table = 'member_category';
    protected $fillable = [
        'category_name',

    ];
    public function member()
    {
        return $this->hasMany(memberDetails::class, 'category_id' , 'id');
    }
}
