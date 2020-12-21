<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ContentLive;
use App\Models\ContentArticle;

class ContentArticleLive extends ContentArticle
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id','title', 'type', 'subheading', 'lead', 'body', 'lower_body', 'alt_block_heading', 'alt_block_text', 'summary_heading', 'summary_text'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_articles_live';

    /**
     * Get the article's content.
     */
    public function content()
    {
        return $this->morphOne(ContentLive::class, 'contentable');

    }

}
