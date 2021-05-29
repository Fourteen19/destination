<?php

namespace App\Models;

use \Spatie\Tags\HasTags;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EventLive extends Event
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
    protected $fillable = ['id', 'uuid', 'title', 'slug', 'date', 'start_time_hour', 'start_time_min', 'end_time_hour', 'end_time_min',
    'venue_name', 'town', 'contact_name', 'contact_number','contact_email', 'booking_link', 'lead_para', 'description', 'video', 'map',
    'summary_heading', 'summary_text', 'summary_image_type', 'updated_by'];


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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events_live';



    /**
     * registerMediaCollections
     * Declares Sptie media collections for later use
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

}
