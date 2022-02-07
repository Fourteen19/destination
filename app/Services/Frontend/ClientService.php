<?php

namespace App\Services\Frontend;

use App\Models\ClientSettings;
use Illuminate\Support\Facades\Redis;

Class ClientService
{


    public function cacheClientSettings($clientId)
    {

        $clientSettings = ClientSettings::select('chat_app', 'font_url', 'font_family', 'colour_bg1', 'colour_bg2', 'colour_bg3', 'colour_txt1', 'colour_txt2', 'colour_txt3',
        'colour_txt4', 'colour_link1', 'colour_link2', 'colour_button1', 'colour_button2', 'colour_button3', 'colour_button4' )->where('client_id', $clientId)->first();

        $logoData = $this->getLogo($clientSettings);

        Redis::set('client:'.$clientId.':client-settings', serialize( array_merge($clientSettings->toArray(), $logoData) ) );

    }



    public function getLogo(ClientSettings $clientSettings)
    {

        $logo = $clientSettings->getMedia('logo')->first();

        if ($logo)
        {
            $logoUrl = parse_encode_url($logo->getUrl());
            $logoAlt = $logo->getCustomProperty('alt');
        } else {
            $logoUrl = "";
            $logoAlt = "";
        }

        return ['logo' => ['url' => $logoUrl, 'alt' => $logoAlt] ];

    }




    public function getCachedClientSettings($clientId)
    {

        if ( !Redis::exists('client:'.$clientId.':client-settings') )
        {
            $this->cacheClientSettings($clientId);

        } else {

        }

        return unserialize(Redis::get('client:'.$clientId.':client-settings'));
    }



/*     public function getClientSettings()
    {
        return $this->getCachedClientSettings(Session::get('fe_client')['id']);
    } */

}
