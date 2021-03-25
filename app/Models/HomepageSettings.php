<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_year', 'client_id',
        'dashboard_slot_1_type', 'dashboard_slot_1_id',
        'dashboard_slot_2_type', 'dashboard_slot_2_id',
        'dashboard_slot_3_type', 'dashboard_slot_3_id',
        'dashboard_slot_4_type', 'dashboard_slot_4_id',
        'dashboard_slot_5_type', 'dashboard_slot_5_id',
        'dashboard_slot_6_type', 'dashboard_slot_6_id',
        'article_feature_slot', 'article_feature_slot_1',
    ];

}
