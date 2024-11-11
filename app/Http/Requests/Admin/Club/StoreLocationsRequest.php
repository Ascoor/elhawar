<?php

namespace App\Http\Requests\Admin\Club;

use App\Http\Requests\CoreRequest;

class StoreLocationsRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            "name" => "required",
            "capacity" => "required|integer",
            "description" => "required",
            "guardian" => "required",

        ];


        return $rules;
    }
}