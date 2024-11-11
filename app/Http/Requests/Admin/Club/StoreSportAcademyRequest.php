<?php

namespace App\Http\Requests\Admin\Club;

use App\Http\Requests\CoreRequest;

class StoreSportAcademyRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            "name" => "required",
            "code" => "required",
            "description" => "required",
        ];


        return $rules;
    }
}