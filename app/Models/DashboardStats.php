<?php

namespace App\Models;

use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DashboardStats extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'year_id',
        'top_article_1',
        'top_article_1_views',
        'top_article_2',
        'top_article_2_views',
        'top_article_3',
        'top_article_3_views',
        'top_article_4',
        'top_article_4_views',
        'top_article_5',
        'top_article_5_views',
        'top_article_6',
        'top_article_6_views',
        'top_article_7',
        'top_article_7_views',
        'top_article_8',
        'top_article_8_views',
        'top_article_9',
        'top_article_9_views',
        'top_article_10',
        'top_article_10_views',
        'top_institution_1',
        'top_institution_1_views',
        'top_institution_2',
        'top_institution_2_views',
        'top_institution_3',
        'top_institution_3_views',
        'top_institution_4',
        'top_institution_4_views',
        'top_institution_5',
        'top_institution_5_views',
        'logins-1',
        'logins-7',
        'logins-30',
        'logins-academic-year',
        'top_vacancy_1',
        'top_vacancy_1_views',
        'top_vacancy_2',
        'top_vacancy_2_views',
        'top_vacancy_3',
        'top_vacancy_3_views',
        'top_vacancy_4',
        'top_vacancy_4_views',
        'top_vacancy_5',
        'top_vacancy_5_views',
        'top_event_1',
        'top_event_1_views',
        'top_event_2',
        'top_event_2_views',
        'top_event_3',
        'top_event_3_views',
        'top_event_4',
        'top_event_4_views',
        'top_event_5',
        'top_event_5_views',
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
//    protected $table = 'content_access';


    public function contentLive()
    {
        return $this->belongsTo(ContentLive::class, 'content_id', 'id');
    }


    /**
     * Get the client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }




    public static function createViewLog(ContentLive $article)
    {
        $postViews = new ContentAccess();
        $postViews->content_id = $article->id;
        $postViews->client_id = Auth::guard('web')->user()->client_id;
        $postViews->institution_id = Auth::guard('web')->user()->institution_id;
        $postViews->user_id = Auth::guard('web')->user()->id;
        $postViews->year_id = app('currentYear');
        $postViews->save();
    }



}
