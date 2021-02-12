<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageLive extends Model implements HasMedia
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
        'uuid', 'title', 'slug', 'client_id', 'template_id', 'order_id'
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

}
