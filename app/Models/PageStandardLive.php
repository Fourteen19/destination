<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PageLive;
use App\Models\PageStandard;

class PageHomeLive extends PageStandard
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'page_standard_live';

    /**
     * Get the article's content.
     */
    public function page()
    {
        return $this->morphOne(PageLive::class, 'pageable');

    }


}
