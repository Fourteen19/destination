<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PageLive;
use App\Models\PageHomepage;

class PageHomepageLive extends PageHomepage
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'banner_title', 'banner_text', 'link1_text', 'link1_page_id', 'link2_text', 'link2_page_id', 'free_articles_block_heading', 'free_articles_block_text', 'free_articles_slot1_page_id', 'free_articles_slot2_page_id', 'free_articles_slot3_page_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'page_homepage_live';

    /**
     * Get the article's content.
     */
    public function page()
    {
        return $this->morphOne(PageLive::class, 'pageable');

    }


}
