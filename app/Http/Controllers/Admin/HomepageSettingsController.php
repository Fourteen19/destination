<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomepageSettings;
use App\Http\Controllers\Controller;

class HomepageSettingsController extends Controller
{

    public function index()
    {

        //check authoridation
        $this->authorize('update', HomepageSettings::class);

        return view('admin.pages.homepage-settings.edit');
    }

}
