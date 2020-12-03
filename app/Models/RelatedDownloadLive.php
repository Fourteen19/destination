<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ContentLive;
use App\Models\RelatedDownload;

class RelatedDownloadLive extends RelatedDownload
{
    use HasFactory;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'related_downloads_live';


    public function content()
    {
        return $this->morphTo();
    }
}
