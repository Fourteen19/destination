<?php

namespace App\Models;

use \Spatie\Tags\HasTags;
use App\Models\EmployerLive;
use App\Scopes\VacancyGlobalAndClientScope;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VacancyLive extends Vacancy
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
    protected $fillable = ['id', 'uuid', 'title', 'slug', 'contact_name', 'contact_number', 'contact_email', 'contact_link', 'employer_id',
    'role_id', 'region_id', 'all_clients', 'client_id', 'category', 'online_link', 'lead_para', 'description', 'map', 'updated_at', 'updated_by', 'deleted_at'];


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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new VacancyGlobalAndClientScope);
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancies_live';


    /**
     * Get the clients who have the vacancy allocated.
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'clients_vacancies_live');
    }


    /**
     * employer
     * used in the backend to retrieve data based on the Uuid
     *
     * @return void
     */
    public function employer()
    {
        return $this->belongsTo(EmployerLive::class);
    }

    /**
     * employerImage
     * This is used to retrieve the employer's logo.
     * Forces the vacancyLive model to use the Employer class as it is the one used in the Media Table
     *
     * @return void
     */
    public function employerImage()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }


}
