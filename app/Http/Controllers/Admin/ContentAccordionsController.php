<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentAccordionsController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //checks policy
        $this->authorize('create', 'App\Models\Content');

        $contentOwner = app('clientService')->getClientNameForAdminPages();

        return view('admin.pages.contents.accordions.create', ['content' => '', 'contentOwner' => $contentOwner]);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $uuid)
    {

        $content = Content::where('uuid', $uuid)->select('uuid', 'client_id')->firstOrFail();

        //check authoridation
        $this->authorize('update', $content);

        $contentOwner = app('clientService')->getClientNameForAdminPages();

        return view('admin.pages.contents.accordions.edit', ['content' => $content->uuid, 'contentOwner' => $contentOwner]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
