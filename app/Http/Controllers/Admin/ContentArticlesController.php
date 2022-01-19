<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class ContentArticlesController extends Controller
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

        return view('admin.pages.contents.articles.create', ['content' => '', 'contentOwner' => $contentOwner]);

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

        $clientSettings = app('clientService')->getClientSettings(Session::get('adminClientSelectorSelected'));

        return view('admin.pages.contents.articles.edit', ['content' => $content->uuid, 'contentOwner' => $contentOwner, 'clientSettings' => $clientSettings]);

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
