<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dashboard extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'slot_1', 'slot_2', 'slot_3', 'slot_4', 'slot_5', 'slot_6', 'ria_slot_1', 'ria_slot_2', 'ria_slot_3', 'sd_slot_1', 'sd_slot_2', 'sd_slot_3', 'hrn_slot_1', 'hrn_slot_2', 'hrn_slot_3', 'hrn_slot_4'
    ];




    /**
     * Get the user that owns the dashboard.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
