<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'chat_app', 'font'
    ];

    public $timestamps = false;

    /**
     * Get the content
     */
    public function client()
    {
        return $this->belongsTo(App\Models\Client::class);
    }

}