<?php

namespace App\Observers;


use App\EngineeringProductSubCategory;
use App\ProductSubCategory;

class EngineeringSubCategoryObserver
{

    public function saving(EngineeringProductSubCategory $category)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $category->company_id = company()->id;
        }
    }

}
