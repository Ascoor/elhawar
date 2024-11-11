<?php

namespace App\Observers;


use App\EngineeringProductCategory;
use App\EngineeringProductSubCategory;

class EngineeringProductCategoryObserver
{

    public function saving(EngineeringProductCategory  $category)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $category->company_id = company()->id;
        }
    }

}
