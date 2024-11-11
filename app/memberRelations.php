<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class memberRelations extends Model
{
    protected $table = 'member_relations';
    protected $fillable = [
        'relation_name',

    ];
    public function member()
    {
        return $this->hasMany(memberDetails::class, 'relation_id' , 'id');
    }
}