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
    protected $fillable = ['title', 'banner_title', 'banner_text', 'link1_text', 'link1_page_id', 'link2_text', 'link2_page_id', 'free_articles_block_heading', 'free_articles_block_text', 'free_articles_slot1_page_id', 'free_articles_slot2_page_id', 'free_articles_slot3_page_id'];

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
