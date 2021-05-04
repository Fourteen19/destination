<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Admin\Admin;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model implements HasMedia
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
        'uuid', 'filename', 'description', 'all_clients', 'admin_id', 'uploaded_date'
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
     * Get the client who have the resource allocated.
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class)->select('id', 'uuid', 'name');
    }



    /**
     * Get the client who have the resource allocated.
     */
    public function resourceClient()
    {
        return $this->belongsToMany(Client::class)
                            ->select('id', 'uuid', 'name');
    }


    /**
     * Get the admin who updloaded the resource allocated.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

     /**
     * registerMediaCollections
     * Declares Sptie media collections for later use
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        //for storing 1 file
        $this->addMediaCollection('resource')->useDisk('media')->singleFile();

    }

}
