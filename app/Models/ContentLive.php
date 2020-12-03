<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Tags\HasTags;
use App\Models\Content;

class ContentLive extends Content
{
    use HasFactory;
    use HasTags;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_live';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    /**
     * Get the videos associated with the content.
     */
    public function videos()
    {
        return $this->morphMany('App\Models\VideoLive', 'videoable');
    }

    /**
     * Get the links associated with the content.
     */
    public function related_links()
    {
        return $this->morphMany('App\Models\relatedLinkLive', 'linkable');
    }

    /**
     * Get the downloads associated with the content.
     */
    public function related_downloads()
    {
        return $this->morphMany('App\Models\relatedDownloadLive', 'downloadable');
    }

}
