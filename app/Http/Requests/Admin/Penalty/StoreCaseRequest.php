<?php

namespace App\Http\Requests\Admin\Penalty;

use App\Http\Requests\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRequest extends CoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "case_name" => "required",
            "case_id" => "required",
            "details" => "required",
            "lawyers" => "required",
            "opponents" => "required",
        ];


        return $rules;
    }


}
