<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content;

class ContentAccordion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'type', 'subheading', 'lead', 'body', 'summary_heading', 'summary_text'
    ];

    /**
     * Get the accordion's content.
     */
    public function content()
    {
        return $this->morphOne(Content::class, 'contentable');

    }

}
