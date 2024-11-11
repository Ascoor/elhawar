<?php

namespace App;

use App\Observers\EngineeringProductCategoryObserver;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class EngineeringProductCategory extends Model
{
    //
    protected $table = 'engineering_product_category';
    protected $fillable = ['category_name', 'description'];
    protected static function boot()
    {
        parent::boot();

        static::observe(EngineeringProductCategoryObserver::class);

        static::addGlobalScope(new CompanyScope);
    }
    public function product_sub_category()
    {
        return $this->hasMany(EngineeringProductSubCategory::class);
    }
}
