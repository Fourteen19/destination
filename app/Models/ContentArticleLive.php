<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ContentLive;
use App\Models\ContentArticle;

class ContentArticleLive extends ContentArticle
{
    use HasFactory;


    /**
     * Get the article's content.
     */
    public function content()
    {
        return $this->morphOne(ContentLive::class, 'contentable');

    }

}
