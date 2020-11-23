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
        'title', 'type', 'lead', 'body', 'statement', 'alt_block_heading', 'alt_block_text', 'content_id'
    ];

    public function content()
    {
        return $this->morphOne(Content::class, 'contentable');

    }

}
