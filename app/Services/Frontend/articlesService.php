<?php

namespace App\Services\Frontend;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



Class articlesService
{

    /**
      * Create a new controller instance.
      *
      * @return void
    */
    public function __construct() {

    }




    public function articleIsRead($article) {

        $exists = DB::table('content_live_user')
        ->whereUserId( Auth::guard('web')->user()->id )
        ->whereContentLiveId($article->id)
        ->count() > 0;

        if (!$exists){
            Auth::guard('web')->user()->articles()->sync($article, [ ]);
        } else {
            Auth::guard('web')->user()->articles()->updateExistingPivot($article, ['nb_read' => DB::raw('nb_read+1') ]);
        }
    
    }



}