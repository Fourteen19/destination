<?php

namespace App\Services\Frontend;

use App\Models\ClientSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class ClientService
{


/*     public function getChatApp()
    {

        $clientId = getClientIdBySubdomain();

        if (is_numeric(getClientIdBySubdomain()))
        {

            //loads the chat app and stores it in the session
            $clientSettings = DB::table('client_settings')->where('client_id', $clientId)->select('chat_app')->get()->toArray();

            if (!empty($clientSettings[0]->chat_app))
            {
                return $clientSettings[0]->chat_app;
            }

        } else {

            return NULL;
        }

    } */


    public function cacheClientSettings($clientId)
    {

        $clientSettings = ClientSettings::select('chat_app', 'font_url', 'font_family', 'colour_bg1', 'colour_bg2', 'colour_bg3', 'colour_txt1', 'colour_txt2', 'colour_txt3',
        'colour_txt4', 'colour_link1', 'colour_link2', 'colour_button1', 'colour_button2', 'colour_button3', 'colour_button4' )->where('id', $clientId)->first()->toArray();

        Redis::set('client:'.$clientId.':client-settings', serialize($clientSettings));

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
