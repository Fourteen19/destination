<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GlobalSettingsController extends Controller
{


    public function index()
    {
        return view('admin.pages.global-settings.index');
    }



}
