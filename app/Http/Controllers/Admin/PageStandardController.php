<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageStandardController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //check authoridation
        $this->authorize('create', Page::class);

        return view('admin.pages.pages.standard.create');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed $request
     * @param  mixed $standard
     * @return void
     */
    public function edit(Request $request, Page $standard)
    {

       //check policy authorisation
       $this->authorize('update', $standard);

       return view('admin.pages.pages.standard.edit');

    }


}
