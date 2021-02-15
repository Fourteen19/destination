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
        'title', 'uuid', 'client_id', 'slug', 'template_id', 'summary_image_type', 'summary_heading' , 'summary_text', 'contentable_type', 'contentable_id', 'word_count', 'updated_at'
    ];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        //static::addGlobalScope(new ContentAdminScope);
    }



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
     * Get the questions associated with the content.
     */
    public function relatedQuestions()
    {
        return $this->morphMany('App\Models\relatedQuestion', 'questionable');
    }


    /**
     * Get the monthly stats record associated with the content.
     */
    public function articlesMonthlyStats()
    {
        return $this->hasOne('App\Models\ArticlesMonthlyStats');
    }


    /**
     * Get the total stats record associated with the content.
     */
    public function articlesTotalStats()
    {
        return $this->hasOne('App\Models\ArticlesTotalStats');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
/*    public function scopePopular(Builder $query)
    {
        if (in_array(Auth::guard('admin')->getRoleNames()->first(), [config("global.admin_user_type.System_Administrator"), config("global.admin_user_type.Global_Content_Admin")]))
        {
            return $query->where('client_id', '=', NULL);

        }
        elseif (in_array(Auth::guard('admin')->getRoleNames()->first(), [config("global.admin_user_type.Client_Admin"), config("global.admin_user_type.Client_Content_Admin")]))
        {

            return $query->where('client_id', '=', Auth::guard('admin')->client_id);

        }
    }
*/
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

        //for storing several supporting/related images
        $this->addMediaCollection('supporting_images')->useDisk('media');

        //for storing several supporting/related downloads
        $this->addMediaCollection('supporting_downloads')->useDisk('media');

        //for storing 1 summary image
        $this->addMediaCollection('summary')->useDisk('media')->singleFile();

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
              ->crop(Manipulations::CROP_CENTER, 2074, 798)
              ->performOnCollections('banner')  //perform conversion of the following collections
              ->nonQueued(); //image created directly

        $this->addMediaConversion('summary_slot1')
              ->crop(Manipulations::CROP_CENTER, 2074, 1056)
              ->performOnCollections('summary')  //perform conversion of the following collections
              ->nonQueued(); //image created directly

        $this->addMediaConversion('summary_slot2-3')
              ->crop(Manipulations::CROP_CENTER, 771, 512)
              ->performOnCollections('summary')  //perform conversion of the following collections
              ->nonQueued(); //image created directly

        $this->addMediaConversion('summary_slot4-5-6')
              ->crop(Manipulations::CROP_CENTER, 1006, 670)
              ->performOnCollections('summary')  //perform conversion of the following collections
              ->nonQueued(); //image created directly

        $this->addMediaConversion('summary_you_might_like')
              ->crop(Manipulations::CROP_CENTER, 737, 737)
              ->performOnCollections('summary')  //perform conversion of the following collections
              ->nonQueued(); //image created directly

        $this->addMediaConversion('search')
              ->crop(Manipulations::CROP_CENTER, 740, 440)
              ->performOnCollections('summary')  //perform conversion of the following collections
              ->nonQueued(); //image created directly

        $this->addMediaConversion('supporting_images')
              ->crop(Manipulations::CROP_CENTER, 1274, 536)
              ->performOnCollections('supporting_images')  //perform conversion of the following collections
              ->nonQueued(); //image created directly

    }

}
