<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductInventory;
class PurchaseTransaction extends Model
{
    protected $table = 'purchase_transactions';

    protected $fillable = ['product', 'prev', 'current','state','date'];
    //
    public function ProductInventory() {
        return $this->hasMany( ProductInventory::class);
    }
}
