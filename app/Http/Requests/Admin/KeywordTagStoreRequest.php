<?php

namespace App\Http\Requests\Admin;

use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\FormRequest;


class KeywordTagStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //access the policy
        return Auth('admin')->user()->can('create', SystemKeywordTag::class);
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
        ];


        //if the form has been submitted with POST
        if ($this->getMethod() == 'POST')
        {

            $rules['name'] .= "|keyword_tag_exists_with_type:keyword,NULL,".Session::get('adminClientSelectorSelected');

        //if the form has been submitted with PATCH
        } elseif ($this->getMethod() == 'PATCH') {

            $rules['name'] .= "|keyword_tag_exists_with_type:keyword,id,".$this->keyword->id.",".getClientId();

        }

        return $rules;

    }


    public function messages()
    {
        return [
            'name.keyword_tag_exists_with_type' => __('validation.keyword_tag_exists_with_type', ['tagtype' => "keyword"]),
        ];
    }
}
