<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'uuid', 'client_id', 'template_id', 'order_id'
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
    public function pageable()
    {
        return $this->morphTo();

    }


    /**
     * Get the template record associated with the content.
     */
    public function pageTemplate()
    {
        return $this->hasOne('App\Models\PageTemplate', 'id', 'template_id');
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

    }

}
