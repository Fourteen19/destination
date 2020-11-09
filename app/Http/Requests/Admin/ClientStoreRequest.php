<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Client;

class ClientStoreRequest extends FormRequest
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
            return Auth('admin')->user()->can('create', Client::class);

        } elseif ($this->getMethod() == 'PATCH') {

            //gets the admin variable
            //$this is Request
            $client = $this->route('client');

            //access the admin policy
            return auth('admin')->user()->can('update', $client);

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
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:50',
            'website' => 'string|max:255',
            'contact' => 'string|max:255',
        ];

        //if the form has been submitted with POST
        if ($this->getMethod() == 'POST') {

            $rules['subdomain'] .= '|unique:clients';

        //if the form has been submitted with PATCH
        } elseif ($this->getMethod() == 'PATCH') {

            $rules['subdomain'] .= '|unique:clients,subdomain,'.$this->client->id;
        }

        return $rules;

    }

}
