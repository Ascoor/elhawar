<?php

namespace App\Http\Requests\Designation;

use App\Http\Requests\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends CoreRequest
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
        $id = $this->route('designation');
        $company_id = request('company_id');
        return [
            'name' =>  [
                'required',
                Rule::unique('designations')->where(function ($query) use($id,$company_id) {
                    return $query->where('company_id', $company_id)->where('id','!=',$id);
                }),
            ],
        ];
    }
}
