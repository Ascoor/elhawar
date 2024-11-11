<?php

namespace Modules\Accounting\Entities;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{

    protected $table='letters_of_guarantee';

    public $appends = [
        'lettype',
     ];

    protected $fillable =
    [
        'issuedToCompany',
        'issuingBank',
        'letterType',
        'letterNumber',
        'amount',
        'description',
        'issuingDate',
        'expirationDate',
    ];
    ////////////////-----------------------------////////////////

    public function getlettypeAttribute()
    {
        return $this->type->name;
    }

    ////////////////-----------------------------////////////////
    public function type()
    {
        return $this->belongsTo(LetterType::class,'letterType');
    }


}
