<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpolyeeAssessmentRequest extends FormRequest
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
        return [
            'ass_name' => 'required',
            'user_id' => 'required',
            'assessment_value.*' => 'required|integer',
            'perc_input' => 'required',
        ];
    }
}
