<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    protected $fillable = ['product', 'inventory', 'price','item_in_stock'];
    //
    public function StockTransactions()
    {
        return $this->belongsTo(PurchaseTransaction::class);
    }
    public function Products()
    {
        return $this->hasMany(Products::class);
    }
}
