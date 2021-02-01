<?php

namespace App\Http\Controllers\Admin;

use App\Models\GlobalSettings;
use App\Http\Controllers\Controller;

class GlobalSettingsController extends Controller
{


    public function index()
    {

        //check authoridation
        $this->authorize('update', GlobalSettings::class);

        return view('admin.pages.global-settings.index');
    }



}
