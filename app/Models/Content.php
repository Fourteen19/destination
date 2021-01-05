<?php

namespace App\Models;

use \Spatie\Tags\HasTags;
use App\Models\ContentArticle;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Content extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasTags;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'uuid', 'client_id', 'slug', 'template_id', 'contentable_type', 'contentable_id', 'month_views', 'total_views', 'updated_at'
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
    public function relatedVideos()
    {
        return $this->morphMany('App\Models\relatedVideo', 'videoable');
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

    /**
     * Get the questions associated with the content.
     */
    public function relatedQuestions()
    {
        return $this->morphMany('App\Models\relatedQuestion', 'questionable');
    }





    /**
     * registerMediaCollections
     * Declares Sptie media collections for later use
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        //for storing 1 banner
        $this->addMediaCollection('banner')->useDisk('media')->singleFile();

        //for storing several supporting images
        $this->addMediaCollection('supporting-images')->useDisk('media');

        //for storing 1 summary image
        $this->addMediaCollection('summary-image')->useDisk('media')->singleFile();

        //for storing several downloads
        $this->addMediaCollection('supporting-images')->useDisk('media');

    }


    /**
     * registerMediaConversions
     * This conversion is applied whenever a Content model is saved
     *
     * @param  mixed $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('banner')
              ->crop(Manipulations::CROP_TOP_RIGHT, 50, 50)
              ->performOnCollections('banner')  //perform conversion of the following collections
              ->nonQueued(); //image created directly
    }

}
