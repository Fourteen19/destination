<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Content;

class ContentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->getMethod() == 'POST') {

            //access the admin policy
            return Auth('admin')->user()->can('create', Content::class);

        } elseif ($this->getMethod() == 'PATCH') {

            //gets the admin variable
            //$this is Request
            $content = $this->route('content');

            //access the admin policy
            return auth('admin')->user()->can('update', $content);

        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'title' => 'required|string|max:255',
            'body' => 'required',
            'tagsSubjects' => ''
        ];

        return $rules;
    }
}
