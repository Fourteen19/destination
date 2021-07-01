<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class EditMyProfileStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'title' => 'required|string|in:Mr,Mrs,Ms,Miss,Dr',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:admins,email,'.Auth::guard('admin')->user()->id,
            'password' => 'nullable|same:confirm-password|min:8',
            'contact_me' => 'nullable|in:Y'
        ];

        return $rules;
    }
}
