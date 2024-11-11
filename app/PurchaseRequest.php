<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $table = 'purchase_requests';
    protected $fillable = [
        'id', 'company_id', 'project_id', 'currency_id', 'client_id', 'issue_date', 'created_by', 'approved', 'approved_by', 'type', 'products', 'total',

    ];
}
