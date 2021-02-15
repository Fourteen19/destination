<?php

namespace App\Services\Admin;

use App\Models\Page;
use App\Models\PageStandard;
use App\Models\PageTemplate;
use App\Services\Admin\PageService;

Class PageStandardService extends PageService
{

    public function storeLivewire($data)
    {

        //create the model record
        $page = PageStandard::create([
            'title' => $data->title,
            'lead' => $data->lead,
            'body' => $data->body,
        ]);

        //fetch the template
        $template = PageTemplate::where('Name', 'Standard')->first();

        $nbPages = Page::where('client_id', getClientId() )->count();

        //creates the model record
        $newPage = $page->page()->create([
                        'template_id' => $template->id,
                        'title' => $data->title,
                        'slug' => $data->slug,
                        'client_id' => getClientId(),
                        'display_in_header' => (empty($data->displayInHeader)) ? 'N' : 'Y',
                        'order_id' => $nbPages + 1,
                    ]);

         //return the new content
        return $newPage;

    }



    public function editLivewire($data)
    {

        $page = Page::where('uuid', $data->pageRef)->get()->first();

        //updates the resource
        $page->update([
            'title' => $data->title,
            'slug' => $data->slug,
            'updated_at' => now(),
            'display_in_header' => (empty($data->displayInHeader)) ? 'N' : 'Y',
        ]);

        //updates the resource
        $page->pageable->update([
            'title' => $data->title,
            'lead' => $data->lead,
            'body' => $data->body,
        ]);

        return $page;

    }


}
