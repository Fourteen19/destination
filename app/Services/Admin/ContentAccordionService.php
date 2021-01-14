<?php

namespace App\Services\Admin;

use App\Models\RelatedLink;
use App\Models\ContentAccordion;
use App\Models\ContentTemplate;
use App\Models\RelatedDownload;
use App\Services\ContentService;
use Illuminate\Support\Facades\Auth;



Class ContentAccordionService extends ContentService
{

    public function storeLivewire($data)
    {

        //create the `article` record
        $article = ContentAccordion::create([
            'title' => $data->title,
            'lead' => $data->lead,
            'subheading' => $data->subheading,
            'body' => $data->body,
            'banner' => $data->banner,
        ]);

        //fetch the template
        $template = ContentTemplate::where('Name', 'Accordion')->first();

        //creates the `content` record
        $newContent = $article->content()->create([
                        'template_id' => $template->id,
                        'title' => $data->title,
                        'slug' => $data->slug,
                        'summary_heading' => $data->summary_heading,
                        'summary_text' => $data->summary_text,
                        'client_id' => Auth::guard('admin')->user()->client_id
                    ]);


        $this->attachTags($data);

        //return the new content
        return $newContent;

    }



    public function editLivewire($data)
    {

        //updates the resource
        $data->content->update([
            'title' => $data->title,
            'timestamps' => false,
            'updated_at' => date('Y-m-d H:i:s')
            'summary_heading' => $data->summary_heading,
            'summary_text' => $data->summary_text,
        ]);

        //updates the resource
        $data->content->contentable->update([
            'title' => $data->title,
            'lead' => $data->lead,
            'subheading' => $data->subheading,
            'body' => $data->body,
        ]);

        $this->syncTags($data);

        return $data->content;

    }


}
