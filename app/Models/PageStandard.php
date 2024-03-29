<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Page;

class PageStandard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'lead', 'body',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'page_standard';


    /**
     * Get the accordion's content.
     */
    public function page()
    {
        return $this->morphOne(Page::class, 'pageable');

    }

}
