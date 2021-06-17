<?php

namespace App\Services\Frontend;

use App\Models\ClientSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class ClientService
{


    public function getChatApp()
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

    }

}