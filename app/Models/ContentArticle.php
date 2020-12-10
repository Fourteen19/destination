<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content;

class ContentArticle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'type', 'subheading', 'lead', 'body', 'lower_body', 'alt_block_heading', 'alt_block_text', 'summary_heading', 'summary_text'
    ];

    /**
     * Get the article's content.
     */
    public function content()
    {
        return $this->morphOne(Content::class, 'contentable');

    }

}
