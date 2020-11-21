<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'image'
    ];


    /**
     * Get the client record associated with the institution.
     */
    public function content()
    {
        return $this->hasMany('App\Models\Content');
    }

}
