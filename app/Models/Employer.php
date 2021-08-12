<?php

namespace App\Models;

use App\Models\Vacancy;
use App\Models\Admin\Admin;
use App\Models\VacancyLive;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'name', 'uuid', 'slug', 'website', 'article_id'
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



    public function article()
    {
        return $this->belongsTo(ContentLive::class)->select('id', 'title', 'summary_heading', 'summary_text', 'slug');
    }



    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }


    /**
     * vacancies_live
     * used to retrieve vacancies related to a company
     *
     * @return void
     */
    public function vacanciesLive()
    {
        return $this->hasMany(VacancyLive::class, 'employer_id', 'id');
    }

    /**
     * Get the client record associated with the model.
     */
    public function client()
    {
        return $this->hasOne('App\Models\Client');
    }

}
