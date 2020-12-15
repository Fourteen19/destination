<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SelfAssessmentSectors extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check())
        {
            return true;
        }

        return false;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'submit' => 'required',
            'sectors' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'sectors.required' => 'Please select at least one option',
        ];
    }

}
