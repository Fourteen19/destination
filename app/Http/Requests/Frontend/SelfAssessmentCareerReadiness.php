<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SelfAssessmentCareerReadiness extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::guard('web')->check())
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
            'cas-1' => 'required|in:"Strongly agree", "Agree", "Neither agree or disagree", "Disagree", "Strongly disagree"',
            'cas-2' => 'required|in:"Strongly agree", "Agree", "Neither agree or disagree", "Disagree", "Strongly disagree"',
            'cas-3' => 'required|in:"Strongly agree", "Agree", "Neither agree or disagree", "Disagree", "Strongly disagree"',
            'cas-4' => 'required|in:"Strongly agree", "Agree", "Neither agree or disagree", "Disagree", "Strongly disagree"',
            'cas-5' => 'required|in:"Strongly agree", "Agree", "Neither agree or disagree", "Disagree", "Strongly disagree"',
        ];
    }


    public function messages()
    {
        return [
            'cas-1.required' => 'Please indicate how confident you are about your future',
            'cas-2.required' => 'Please indicate if you understand all the different career options and choices',
            'cas-3.required' => 'Please indicate if you make good decisions and choices',
            'cas-4.required' => 'Please indicate if you know what you need to do to achieve my career goals',
            'cas-5.required' => 'Please indicate if you are worried you won’t be able to achieve your career goals',

            'cas-1.in' => 'Please indicate how confident you are about your future',
            'cas-2.in' => 'Please indicate if you understand all the different career options and choices',
            'cas-3.in' => 'Please indicate if you make good decisions and choices',
            'cas-4.in' => 'Please indicate if you know what you need to do to achieve my career goals',
            'cas-5.in' => 'Please indicate if you are worried you won’t be able to achieve your career goals',
        ];
    }

}
