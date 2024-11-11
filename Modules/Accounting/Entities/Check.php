<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{

    protected $table='checks';

    public $appends = [
        'AccountType',

     ];

    protected $fillable =
    [
        'bank_account_type_id',
        'number',
        'date',
        'bankName',
        'recipient',
        'amount',
        'status',
        'cashed',
        'code_id',
    ];
    ////////////////-----------------------------////////////////
    public function getAccountTypeAttribute()
    {
        return $this->bankAccountType->name;
    }

    ////////////////-----------------------------////////////////
    public function bankAccountType()
    {
        return $this->belongsTo(BankAccountType::class,'bank_account_type_id');
    }
    public function bankCode()
    {
        return $this->belongsTo(Code::class,'code_id');
    }



}
