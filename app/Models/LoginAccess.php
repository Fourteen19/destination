<?php

namespace App\Models;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginAccess extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_id', 'institution_id', 'year_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'login_access';


    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }


}
