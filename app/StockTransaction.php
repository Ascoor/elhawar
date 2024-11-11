<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductInventory;
class StockTransaction extends Model
{
    protected $table = 'stock_transactions';

    protected $fillable = ['product', 'prev', 'current','state','date'];
    //
    public function ProductInventory() {
        return $this->hasMany( ProductInventory::class);
    }
}
