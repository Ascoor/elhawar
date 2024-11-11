<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{

    protected $table='bank_transfers';

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
        'status'
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


}
