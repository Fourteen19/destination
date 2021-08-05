<?php

namespace App\Models;

use App\Models\Event;
use App\Models\EventLive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventAccess extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'year_id', 'event_id',
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events_access';


    public function eventLive()
    {
        return $this->belongsTo(EventLive::class, 'event_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
