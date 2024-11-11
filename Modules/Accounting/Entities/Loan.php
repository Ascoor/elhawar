<?php
namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{

    // region Properties

    protected $table = 'loans';

    protected $fillable =
    [
        'borrower',
        'amount',
        'description',
        'issuingDate',
        'expirationDate',
    ];

}
