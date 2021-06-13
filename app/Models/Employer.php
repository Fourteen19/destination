<?php

namespace App\Models;

use App\Models\Admin\Admin;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employer extends Model implements HasMedia
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
        'name', 'uuid', 'slug', 'website'
    ];


    /**
     * Get the route key for the model.
     *
     * The route key name used in the backend is the uuid
     *
     * The route key name used in the frontend is the slug
     * This is specified in the routeServiceProvider
     *
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }



    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

}
