<?php

namespace App\Services\Admin;

use App\Models\ContentArticle;
use App\Models\ContentTemplate;
use App\Services\Admin\ContentService;
use Illuminate\Support\Facades\Auth;


Class ContentArticleService extends ContentService
{

    public function storeLivewire($data)
    {

        //create the `article` record
        $article = ContentArticle::create([
            'title' => $data->title,
            'lead' => $data->lead,
            'subheading' => $data->subheading,
            'body' => $data->body,
            'alt_block_heading' => $data->alt_block_heading,
            'alt_block_text' => $data->alt_block_text,
            'lower_body' => $data->lower_body,
        ]);

        //fetch the template
        $template = ContentTemplate::where('Name', 'Article')->first();

        //creates the `content` record
        $newContent = $article->content()->create([
                        'template_id' => $template->id,
                        'title' => $data->title,
                        'slug' => $data->slug,
                        'summary_heading' => $data->summary_heading,
                        'summary_text' => $data->summary_text,
                        'client_id' => Auth::guard('admin')->user()->client_id,
                        'word_count' => $this->calculateNbWordsToRead($data)
                    ]);


        $this->attachTags($data, $newContent);

         //return the new content
        return $newContent;

    }



    public function editLivewire($data)
    {

        //updates the resource
        $data->content->update([
            'title' => $data->title,
            'timestamps' => false,
            'summary_heading' => $data->summary_heading,
            'summary_text' => $data->summary_text,
            'updated_at' => date('Y-m-d H:i:s'),
            'word_count' => $this->calculateNbWordsToRead($data),
        ]);

        //updates the resource
        $data->content->contentable->update([
            'title' => $data->title,
            'lead' => $data->lead,
            'subheading' => $data->subheading,
            'body' => $data->body,
            'alt_block_heading' => $data->alt_block_heading,
            'alt_block_text' => $data->alt_block_text,
            'lower_body' => $data->lower_body,
        ]);


        $this->syncTags($data);

        return $data->content;

    }


    /**
     * calculateNbWordsToRead
     * adds the number of words in an article
     * this is used to calculate the time it takes to read an article
     *
     * @param  mixed $data
     * @return void
     */
    public function calculateNbWordsToRead($data)
    {

        return str_word_count(strip_tags($data->title)) + str_word_count(strip_tags($data->lead)) + str_word_count(strip_tags($data->subheading))
        + str_word_count(strip_tags($data->body)) + str_word_count(strip_tags($data->lower_body)) + str_word_count(strip_tags($data->alt_block_heading)) +
        str_word_count(strip_tags($data->alt_block_text));

    }


}
