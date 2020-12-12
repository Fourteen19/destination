<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Spatie\Tags\HasTags;
use App\Models\ContentArticle;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'uuid', 'client_id', 'slug', 'template_id', 'contentable_type', 'contentable_id', 'updated_at'
    ];


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }


    /**
     * Get the client record associated with the content.
     */
    public function client()
    {
        return $this->hasOne('App\Models\Client');
    }


    /**
     * Get the record associated with the content.
     */
    public function contentable()
    {
        return $this->morphTo();

    }

    /**
     * Get the template record associated with the content.
     */
    public function contentTemplate()
    {
        return $this->hasOne('App\Models\ContentTemplate', 'id', 'template_id');
    }


    /**
     * Get the videos associated with the content.
     */
    public function videos()
    {
        return $this->morphMany('App\Models\Video', 'videoable');
    }

    /**
     * Get the links associated with the content.
     */
    public function relatedLinks()
    {
        return $this->morphMany('App\Models\relatedLink', 'linkable');
    }

    /**
     * Get the downloads associated with the content.
     */
    public function relatedDownloads()
    {
        return $this->morphMany('App\Models\relatedDownload', 'downloadable');
    }

}
