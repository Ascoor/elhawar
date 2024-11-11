<?php

namespace App;

use App\Observers\EngineeringProductCategoryObserver;
use App\Scopes\CompanyScope;

class ProductCategory extends BaseModel
{
    protected $table = 'product_category';
    protected $fillable = ['name', 'description'];
    protected static function boot()
    {
        parent::boot();

        static::observe(EngineeringProductCategoryObserver::class);

        static::addGlobalScope(new CompanyScope);
    }
    public function product_sub_category()
    {
        return $this->hasMany(ProductSubCategory::class);
    }
}
