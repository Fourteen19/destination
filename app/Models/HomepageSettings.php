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


    protected $table= 'clients_articles_settings';


    /**
     * Gets the dashboard managed slot 1 article
     */
    public function getDashboardSlot1ManagedArticle()
    {
        return $this->hasOne(\App\Models\ContentLive::class, 'id', 'dashboard_slot_1_id');
    }


    /**
     * Gets the dashboard manage slot 2 article
     */
    public function getDashboardSlot2ManagedArticle()
    {
        return $this->hasOne(\App\Models\ContentLive::class, 'id', 'dashboard_slot_2_id');
    }


    /**
     * Gets the dashboard manage slot 3 article
     */
    public function getDashboardSlot3ManagedArticle()
    {
        return $this->hasOne(\App\Models\ContentLive::class, 'id', 'dashboard_slot_3_id');
    }



    /**
     * Gets the dashboard manage slot 4 article
     */
    public function getDashboardSlot4ManagedArticle()
    {
        return $this->hasOne(\App\Models\ContentLive::class, 'id', 'dashboard_slot_4_id');
    }


    /**
     * Gets the dashboard manage slot 5 article
     */
    public function getDashboardSlot5ManagedArticle()
    {
        return $this->hasOne(\App\Models\ContentLive::class, 'id', 'dashboard_slot_5_id');
    }



    /**
     * Gets the dashboard manage slot 6 article
     */
    public function getDashboardSlot6ManagedArticle()
    {
        return $this->hasOne(\App\Models\ContentLive::class, 'id', 'dashboard_slot_6_id');
    }


    /**
     * Gets the Article feature article
     */
    public function getFeaturedArticle()
    {
        return $this->hasOne(\App\Models\ContentLive::class, 'id', 'article_feature_slot_1');
    }



    /**
     * Get the client
     */
    public function client()
    {
        return $this->belongsTo(App\Models\Client::class);
    }


}
