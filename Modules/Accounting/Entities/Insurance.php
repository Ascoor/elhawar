<?php

namespace Modules\Accounting\Entities;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{

    protected $table='insurances';

    public $appends = [
        'insuranceType',
     ];

    protected $fillable =
    [
        'insurance_type_id',
        'amount',
        'paymentDate',
        'returnDate',
        'purpose',
    ];
    ////////////////-----------------------------////////////////

    public function getinsuranceTypeAttribute()
    {
        return $this->type->name;
    }

    ////////////////-----------------------------////////////////
    public function type()
    {
        return $this->belongsTo(InsuranceType::class,'insurance_type_id');
    }


}
