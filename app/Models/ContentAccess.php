<?php

namespace App\Models;

use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    public function contentLive()
    {
        return $this->belongsTo(ContentLive::class, 'content_id', 'id');
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
