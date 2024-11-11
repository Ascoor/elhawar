<?php

namespace App\Http\Requests\Admin\Penalty;

use App\Http\Requests\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePenaltyRequest extends CoreRequest
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
            // "amount" => "nullable|numeric",
            //rola
            "amount" => "nullable",
            "details"=>"required",

        ];


        return $rules;
    }


}
