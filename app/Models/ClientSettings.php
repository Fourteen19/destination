<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ClientSettings extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'chat_app',
        'font_url', 'font_family',
        'logo_path', 'logo_alt',
        'colour_bg1', 'colour_bg2', 'colour_bg3',
        'colour_txt1', 'colour_txt2', 'colour_txt3', 'colour_txt4',
        'colour_link1', 'colour_link2',
        'colour_button1', 'colour_button2', 'colour_button3', 'colour_button4',
    ];

    public $timestamps = false;

    /**
     * Get the content
     */
    public function client()
    {
        return $this->belongsTo(App\Models\Client::class);
    }


    /**
     * registerMediaCollections
     * Declares Sptie media collections for later use
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {

        $this->addMediaCollection('logo')->useDisk('media');

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

        $this->addMediaConversion('logo_no_resize')
            ->performOnCollections('logo')  //perform conversion of the following collections
            ->quality(75)
            ->nonQueued(); //image created directly

    }

}
