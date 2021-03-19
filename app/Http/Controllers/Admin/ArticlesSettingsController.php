<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ArticlesSettingsController extends Controller
{


    public function edit()
    {

        //check authoridation
        //$this->authorize('update', GlobalSettings::class);

        return view('admin.pages.articles-settings.edit');
    }



}
