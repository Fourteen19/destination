<?php

namespace App\Rules;

use App\Models\SystemTag;
use Illuminate\Contracts\Validation\Rule;


class KeywordTagExistsWithType implements Rule
{

    protected $tagType;

    protected $uuidColumn;

    protected $clientId;

    public function __construct($tagType,  $uuidColumn = 'NULL', $clientId = 'NULL')
    {
        $this->tagType = $tagType;
        $this->uuidColumn = $uuidColumn;
        $this->clientId = $clientId;
    }

    public function passes($attribute, $value)
    {
        $locale = $locale ?? app()->getLocale();

        if ($this->uuidColumn)
        {
           // dd(SystemTag::matching($value)->where('type', $this->tagType)->get()->count());
            //select * from `tags` where lower(json_unquote(json_extract(`name`, '$."en"'))) = ? and `type` = ?"
            return SystemTag::matching($value)->where('type', $this->tagType)->where('client_id', $this->clientId)->get()->count() == 0;
        } else {
            return SystemTag::matching($value)->where('type', $this->tagType)->where('uuid', '!=', $this->uuidColumn)->where('client_id', $this->clientId)->get()->count() == 1;
        }

    }

    public function message()
    {
        return 'The validation error message.';
    }
}
