<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidClient implements Rule
{

    protected $allClients;

    public function __construct($allClients)
    {
        $this->allClients = $allClients;
    }

    public function passes($attribute, $value)
    {


        if ( ($this->allClients == null) && ($value == null) ) {
            return False;
        }

    }


    public function message()
    {
        return 'Please select a client';
    }
}
