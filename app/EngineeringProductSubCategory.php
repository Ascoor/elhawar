<?php

namespace App;

use App\Observers\EngineeringSubCategoryObserver;
use App\Observers\ProductSubCategoryObserver;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class EngineeringProductSubCategory extends Model
{
    //
    protected $table = 'engineering_product_sub_category';

    protected static function boot()
    {
        parent::boot();

        static::observe(EngineeringSubCategoryObserver::class);

        static::addGlobalScope(new CompanyScope);
    }

    public function category()
    {
        return $this->belongsTo(EngineeringProductCategory::class, 'category_id');
    }
}
