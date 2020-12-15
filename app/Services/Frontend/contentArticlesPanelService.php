<?php

namespace App\Services\Frontend;

use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;


Class contentArticlesPanelService
{

    //contains the ID of articles displayed in the panel
    //this is used to prevent duplication
    protected $articlePanel;

    //contains global articles
    protected $globalArticles;

    //contains articles related to the year
    protected $yearArticles;



    public function __construct(){

        $this->articlePanel = [];

        $this->articlePanelSlots = [];

    }


    public function init()
    {

        //->whereNotIn('id', $this->articlePanel)

        $this->yearArticles = ContentLive::withAnyTags([Auth::user()->school_year], 'year')->get();

        $this->globalArticles = ContentLive::withAnyTags(['global'], 'flag')->get();

    }



    public function getSlot1()
    {

        $this->init();

        $this->articlePanelSlots['slot1'] = NULL;

        $this->yearArticles->each(function ($item, $key) {

            if (!in_array($item->id, $this->articlePanel))
            {
                $this->articlePanel[] = $item->id;

                $this->articlePanelSlots['slot1'] = $item;

                //breaks the loop
                return false;

            }

        });

        return $this->articlePanelSlots['slot1'];

    }


    public function getSlot2()
    {

        $this->articlePanelSlots['slot2'] = NULL;

        $this->yearArticles->each(function ($item, $key) {

            if (!in_array($item->id, $this->articlePanel))
            {
                $this->articlePanel[] = $item->id;

                $this->articlePanelSlots['slot2'] = $item;

                //breaks the loop
                return false;

            }

        });

        return $this->articlePanelSlots['slot2'];
    }



    public function getSlot3()
    {


    }
}
