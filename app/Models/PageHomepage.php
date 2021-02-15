<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Page;

class PageHomepage extends Model
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
    protected $table = 'page_homepage';


    /**
     * Get the accordion's content.
     */
    public function page()
    {
        return $this->morphOne(Page::class, 'pageable');

    }

}
