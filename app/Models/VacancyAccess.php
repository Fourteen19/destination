<?php

namespace App\Models;

use App\Models\Vacancy;
use App\Models\VacancyLive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VacancyAccess extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'year_id', 'vacancy_id',
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vacancies_access';


    public function vacancyLive()
    {
        return $this->belongsTo(VacancyLive::class, 'vacancy_id', 'id');
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id', 'id');
    }


}
