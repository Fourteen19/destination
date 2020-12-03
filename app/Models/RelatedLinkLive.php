<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ContentLive;
use App\Models\RelatedLink;

class RelatedLinkLive extends RelatedLink
{
    use HasFactory;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'related_links_live';


    public function content()
    {
        return $this->morphTo();
    }
}
