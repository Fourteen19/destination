<?php

namespace App\Models;

use App\Models\Content;
use \Spatie\Tags\HasTags;
use App\Models\SystemTag;
use App\Scopes\GlobalAndClientScope;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ContentLive extends Content
{
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'body', 'uuid', 'client_id', 'slug', 'template_id', 'contentable_type', 'contentable_id', 'month_views', 'total_views', 'updated_at'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contents_live';

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new GlobalAndClientScope);
    }


    public static function getTagClassName(): string
    {
        return SystemTag::class;
    }

    /**
     * Overwrites `HasTags` Trait function
     * override the tags() method from the trait to tell Laravel that it still needs to look for tags_id column for tags relation instead of
     * your_tag_model_id. (Here the relation would have been `system_tag_id`)
     *
     */
   public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->withPivot(['assessment_answer', 'score'])
            ->orderBy('order_column');
    }



    /**
     * Gets the users who have read the article
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class);
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
    }
}
