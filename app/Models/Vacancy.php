<?php

namespace App\Models;

use App\Models\Client;
use \Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacancy extends Model implements HasMedia
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
    protected $fillable = ['vacancy_id', 'uuid', 'title', 'slug', 'contact_name', 'contact_number', 'contact_email', 'contact_link', 'employer_id',
    'role_id', 'region_id', 'client_id', 'all_clients', 'category', 'online_link', 'lead_para', 'description', 'map', 'updated_at', 'updated_by'];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancies';


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
     * Get the clients who have the vacancy allocated.
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'clients_vacancies');
    }



    /**
     * Checks if resource can be seen by admin by checking the allocation
     */
    public function canBeSeenByAdmin()
    {
        return $this->belongsToMany(Client::class)
                            ->select('id', 'uuid', 'title')
                            ->where('id', '=', Auth::guard('admin')->user()->client_id)
                            ->limit(1);
    }



    /**
     * Get the role of the vacancy.
     */
    public function role()
    {
        return $this->belongsTo(VacancyRole::class);
    }


    /**
     * Get the region of the vacancy.
     */
    public function region()
    {
        return $this->belongsTo(VacancyRegion::class);
    }


    /**
     * Get the employer of the vacancy.
     */
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * Get the videos associated with the vacancy.
     */
    public function relatedVideos()
    {
        return $this->morphMany('App\Models\RelatedVideo', 'videoable');
    }
}
