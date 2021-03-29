<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\SystemTag;


class SubjectTagStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //access the admin policy
        return Auth('admin')->user()->can('create', SystemTag::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'name' => 'required|string|max:255',
            'live' => 'required',
            'text' => 'string',
        ];

        //if the form has been submitted with POST
        if ($this->getMethod() == 'POST') {

            //$rules['name'] .= "|tag_exists_with_type('sector')";
            $rules['name'] .= "|tag_exists_with_type:subjects,NULL";

        //if the form has been submitted with PATCH
        } elseif ($this->getMethod() == 'PATCH') {

            $rules['name'] .= "|tag_exists_with_type:subjects,id,".$this->subject->id;

        }

        return $rules;

    }


    public function messages()
    {
        return [
            'name.tag_exists_with_type' => __('validation.tag_exists_with_type', ['tagtype' => "subject"]),
        ];
    }
}
