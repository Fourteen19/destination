<?php

namespace App\Models;

use App\Models\Vacancy;
use App\Models\Admin\Admin;
use App\Models\VacancyLive;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EmployerLive extends Employer
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


    protected $table = 'employers';


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
        return 'slug';
    }



    public function admins()
    {
        return $this->hasMany(Admin::class);
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
    public function vacancies_live()
    {
        return $this->hasMany(VacancyLive::class, 'employer_id', 'id');
    }

}
