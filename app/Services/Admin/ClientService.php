<?php

namespace App\Services\Admin;

use App\Models\Client;

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
        $clients = Client::select('id', 'uuid', 'name')->get()->toArray();

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

}
