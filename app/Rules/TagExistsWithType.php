<?php

namespace App\Rules;

use App\Models\SystemTag;
use Illuminate\Contracts\Validation\Rule;


class TagExistsWithType implements Rule
{

    protected $tagType;

    protected $idColumn;

    public function __construct($tagType, $idColumn = 'NULL')
    {
        $this->tagType = $tagType;
        $this->idColumn = $idColumn;
    }

    public function passes($attribute, $value)
    {
        $locale = $locale ?? app()->getLocale();

        if ($this->idColumn)
        {
           // dd(SystemTag::matching($value)->where('type', $this->tagType)->get()->count());
            //select * from `tags` where lower(json_unquote(json_extract(`name`, '$."en"'))) = ? and `type` = ?"
            return SystemTag::matching($value)->where('type', $this->tagType)->get()->count() == 0;
        } else {
            return SystemTag::matching($value)->where('type', $this->tagType)->where('id', '!=', $this->idColumn)->get()->count() == 1;
        }

    }

    public function message()
    {
        return 'The validation error message.';
    }
}
