<?php

namespace App;

use App\Observers\ProductObserver;
use App\Scopes\CompanyScope;

class Product extends BaseModel
{
    protected $table = 'products';

    protected $fillable = ['name', 'status', 'tax_id','category_id','expiration_date' ,'item_in_stock','allow_purchase'];
    protected $appends = ['total_amount'];

    protected static function boot()
    {
        parent::boot();

        static::observe(ProductObserver::class);

        static::addGlobalScope(new CompanyScope);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
    public function inventory()
    {
        return $this->belongsTo(ProductInventory::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(ProductSubCategory::class, 'sub_category_id');
    }

    public static function taxbyid($id) {
        return Tax::where('id', $id)->withTrashed();
    }

    public function getTotalAmountAttribute(){

        if(!is_null($this->price) && !is_null($this->tax)){
            return $this->price + ($this->price * ($this->tax->rate_percent/100));
        }

        return "";
    }
}
