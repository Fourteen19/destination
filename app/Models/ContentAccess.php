<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentAccess extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_id', 'institution_id', 'year_id', 'content_id',
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'content_access';


}
