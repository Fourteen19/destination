<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailDelimited implements Rule
{

    protected $characterDelimiter;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($characterDelimiter)
    {
        $this->characterDelimiter = $characterDelimiter;

    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $emails = explode($this->characterDelimiter, $value);

        $rules = [
            'email' => 'required|email',
        ];
        if ($emails) {
            foreach ($emails as $email) {
                $data = [
                    'email' => $email
                ];
                $validator = \Validator::make($data, $rules);
                if ($validator->fails()) {
                    return false;
                }
            }
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
