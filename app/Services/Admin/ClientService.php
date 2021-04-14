<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Models\ClientSettings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class ClientService
{

    /**
     * createClientList
     * Generates the dropdown used in admin listing the clients
     *
     * @return void
     */
    public function createClientList($initiate = FALSE)
    {

        //selects all the clients
        $clients = Client::select('id', 'uuid', 'name', 'subdomain')->orderBy('name', 'ASC')->get()->toArray();

        $clientsList = [];
        foreach($clients as $key => $value)
        {
            $clientsList[ $value['uuid'] ] = $value['name'];

            //sets the first client as default client to manage
            if ( ($initiate) && ($key == 0) )
            {
                session(['adminClientSelectorSelection' => $value['uuid'] ]);
                session(['adminClientSelectorSelected'=> $value['id'] ]);
                session(['client' => $value]);
            }
        }

        //we store in a session all the current clients to appear in the client selector
        session(['all_clients' =>  $clientsList]);

    }




    public function getClientDetails($uuid)
    {
        $client = Client::select('name', 'subdomain', 'suspended')->where('uuid', '=', $uuid)->first()->toArray();
        if (!$client)
        {
            abort(403);
        } else {
            return $client;
        }
    }




    public function getClientNameForAdminPages()
    {

        if (isGlobalAdmin()){

            //check if the route is global or client
            //$contentOwner = (Route::is('admin.global*')) ? "Global" : Session::get('client')['name'] ;
            if (Route::is('admin.global*')){
                $contentOwner = "Global";
            } else {

                //determine if present in the session and is not null
                if ( Session::has('adminClientSelectorSelection') )
                {
                    $contentOwner = Session::get('all_clients')[ Session::get('adminClientSelectorSelection') ];
                } else {
                    $contentOwner = "Undefined";
                }

            }

        } elseif (isClientAdmin()){
            $contentOwner = Session::get('adminClientName');

        }

        return $contentOwner;
    }



    /**
     * storeSettings
     *
     * Stores in the DB the client settings
     *
     * @return void
     */
    public function storeSettings($data)
    {

        $clientSettings = ClientSettings::where('id', session()->get('adminClientSelectorSelected') )->first();

        $clientSettings->chat_app = $data->chat_app;
        $clientSettings->font = $data->font;

        $clientSettings->save();

    }


}
