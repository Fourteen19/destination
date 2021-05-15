<?php

namespace App\Models;


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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['vacancy_id','uuid', 'title', 'contact_name', 'contact_number', 'contact_email', 'contact_link', 'employer_name', 'role_type', 'area',
    'category', 'online_link', 'lead_para', 'text', 'video', 'map'];


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
        return $this->belongsToMany(Vacancy::class)->select('id', 'uuid', 'title');
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
}
