<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SelfAssessmentCheckAtLeastOneIsSubjectIsSelected implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        //A subject MUST be select with "I like it" Or "I don't mind it"
        if (in_array('I like it', $value))
        {
            return True;
        } else {
            return in_array('I dont mind it', $value);
        }

        return false;

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
