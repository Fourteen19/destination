<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Content;

class ContentArticleStoreRequest extends FormRequest
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

            //gets the route variable
            //$this is Request
            $resourceUuid = $this->route('article');

            $content = Content::where('uuid', $resourceUuid)->firstOrFail();

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
            'lead' => '',
            'body' => '',
            'tagsSubjects' => ''
        ];

        return $rules;

    }
}
