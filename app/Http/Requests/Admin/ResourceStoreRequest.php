<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Resource;

class ResourceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return True;

        if ($this->getMethod() == 'POST') {

            //access the admin policy
            return Auth('admin')->user()->can('create', Resource::class);

        } elseif ($this->getMethod() == 'PATCH') {

            //gets the admin variable
            //$this is Request
            $resource = $this->route('resource');

            //access the admin policy
            return auth('admin')->user()->can('update', $resource);

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
            'filename' => 'required|string|max:255',
            'customFile_label' => 'required|string|max:255|file_exists',
            'description' => 'required',
        ];

        //if user is global admin, we muse indicate the client
        if (isGlobalAdmin()){
            $rules['all_clients'] = 'required_without:clients|In:Y';
            $rules['clients'] = '';
        }

        return $rules;

    }


    public function messages()
    {
        return [
            'customFile_label.required' => 'Please select a file',
            'all_clients.required_without' => 'Please select the clients you want to allocate this resource to',
            'customFile_label.file_exists' => 'The selected file does not exist'
        ];
    }

}
