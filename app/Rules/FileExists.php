<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileExists implements Rule
{

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;

    }

    public function passes($attribute, $value)
    {

        $path = public_path($value);

        return file_exists($path);

    }


    public function message()
    {
        return 'This file does not exists';
    }
}
