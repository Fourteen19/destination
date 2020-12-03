<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ContentLive;
use App\Models\ContentAccordion;

class ContentAccordionLive extends ContentAccordion
{
    use HasFactory;

    /**
     * Get the accordion's content.
     */
    public function content()
    {
        return $this->morphOne(ContentLive::class, 'contentable');

    }

}
