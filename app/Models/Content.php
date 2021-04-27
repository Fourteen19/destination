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
        'title', 'uuid', 'client_id', 'slug', 'template_id', 'summary_image_type', 'summary_heading' , 'summary_text', 'contentable_type', 'contentable_id', 'word_count', 'read_next_article_id', 'updated_at', 'updated_by'
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
        return $this->morphMany('App\Models\RelatedVideo', 'videoable');
    }

    /**
     * Get the links associated with the content.
     */
    public function relatedLinks()
    {
        return $this->morphMany('App\Models\RelatedLink', 'linkable');
    }

    /**
     * Get the questions associated with the content.
     */
    public function relatedQuestions()
    {
        return $this->morphMany('App\Models\RelatedQuestion', 'questionable');
    }

    /**
     * Get the activity questions associated with the content.
     */
    public function relatedActivityQuestions()
    {
        return $this->morphMany('App\Models\RelatedActivityQuestion', 'activquestionable');
    }


    /**
     * Get the activity specific question associated with the content.
     */
    public function relatedActivitySpecificQuestions($orderId)
    {
        return $this->morphMany('App\Models\RelatedActivityQuestion', 'activquestionable')->where('order_id', $orderId)->limit(1);
    }

    /**
     * Get the activity answers associated with the content.
     */
    public function relatedActivityQuestions_data()
    {
        return $this->morphMany('App\Models\RelatedActivityQuestion', 'activquestionable')->select('id', 'uuid', 'text');
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
     * registerMediaCollections
     * Declares Sptie media collections for later use
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        //for storing 1 banner
        $this->addMediaCollection('banner')->useDisk('media')->onlyKeepLatest(1);//->singleFile()

        //for storing several supporting/related images
        $this->addMediaCollection('supporting_images')->useDisk('media')->onlyKeepLatest(1);

        //for storing several supporting/related downloads
        $this->addMediaCollection('supporting_downloads')->useDisk('media')->onlyKeepLatest(1);

        //for storing 1 summary image
        $this->addMediaCollection('summary')->useDisk('media')->singleFile()->onlyKeepLatest(1);

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

        //if activity
/*         if (in_array($this->template_id, [3]))
        { */

            $this->addMediaConversion('banner')
                ->crop(Manipulations::CROP_CENTER, 1194, 800)
                ->performOnCollections('banner')  //perform conversion of the following collections
                ->nonQueued(); //image created directly
/*
        } else { */

            $this->addMediaConversion('banner')
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->performOnCollections('banner')  //perform conversion of the following collections
                ->nonQueued(); //image created directly
/*         } */

/*         //if article,
        if (in_array($this->template_id, [1, 2]))
        { */
            $this->addMediaConversion('summary_slot1')
                ->crop(Manipulations::CROP_CENTER, 1037, 528)
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

/*         } */

        $this->addMediaConversion('supporting_images')
              //->crop(Manipulations::CROP_CENTER, 1274, 536)
              ->performOnCollections('supporting_images')  //perform conversion of the following collections
              ->nonQueued(); //image created directly
/*
        if (in_array($this->template_id, [3]))
        { */
            $this->addMediaConversion('summary_slot')
                ->performOnCollections('summary')  //perform conversion of the following collections
                ->nonQueued(); //image created directly

/* S */

    }


    /**
     * activities
     * returns content activities related to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activityUsers()
    {
        return $this->belongsToMany(User::class, 'content_activity_user');
    }


    /**
     * Gets the data about a specific users who has read the activity ->where('user_id', $userId)
     */
    public function activitySpecificUser()
    {
        return $this->belongsToMany(\App\Models\User::class, 'content_activity_user');
    }
}
