<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ContentLive;
use App\Models\ContentAccordion;

class ContentAccordionLive extends ContentAccordion
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','title', 'subheading', 'lead', 'body'
     ];//, 'type'

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_accordions_live';

    /**
     * Get the accordion's content.
     */
    public function content()
    {
        return $this->morphOne(ContentLive::class, 'contentable');

    }

}
