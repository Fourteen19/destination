<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasTags;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'title', 'slug', 'date', 'start_time_hour', 'start_time_min', 'end_time_hour', 'end_time_min',
    'venue_name', 'town', 'contact_name', 'contact_number','contact_email', 'booking_link', 'lead_para', 'description', 'map', 'is_internal',
    'all_clients', 'all_institutions', 'client_id', 'institution_specific', 'summary_heading', 'summary_text', 'summary_image_type', 'updated_by', 'created_by'];



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
     * Get the institutions for the client.
     */
    public function client()
    {
        return $this->belongsTo('App\Models\client');
    }


    /**
     * Get the institutions for the client.
     */
    public function institutions()
    {
        return $this->belongsToMany('App\Models\Institution', 'events_institutions')->select('id', 'uuid', 'name')->orderBy('name', 'asc');
    }



    /**
     * registerMediaCollections
     * Declares Spatie media collections for later use
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        //for storing 1 banner
        $this->addMediaCollection('banner')->useDisk('media');//->singleFile()

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

        $this->addMediaConversion('large')
            ->crop(Manipulations::CROP_CENTER, 1037, 528)
            ->performOnCollections('summary')  //perform conversion of the following collections
            ->quality(75)
            ->nonQueued(); //image created directly

        $this->addMediaConversion('small')
            ->crop(Manipulations::CROP_CENTER, 528, 528)
            ->performOnCollections('summary')  //perform conversion of the following collections
            ->quality(75)
            ->nonQueued(); //image created directly

    }


    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', "=", $clientId);
    }


    public function scopeIsNotInternal($query)
    {
        return $query->where('is_internal', "=", "N");
    }

}
