<?php


use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




if (!function_exists('getClientIdBySubdomain'))
{

    function getClientIdBySubdomain()
    {

        $clientId = NULL;

        // Extract the subdomain from URL
        list($subdomain) = explode('.', request()->getHost(), 2);

        if ($subdomain != 'www')
        {

            // Retrieve requested tenant's info from database. If not found, abort the request.
            //->select('suspended')
            $client = Client::select('id')->where('subdomain', $subdomain)->firstOrFail();
            $clientId = $client->id;
        }

        return $clientId;

    }

}



if (!function_exists('getClientId'))
{

    function getClientId()
    {

        $clientId = NULL;

        if (isGlobalAdmin()){

            //determine if present in the session and is not null
            if ( session('adminClientSelectorSelection') )
            {
                $clientData = DB::table('clients')->select('id')->where('uuid', '=', session('adminClientSelectorSelection') )->get()->first();
                $clientId = $clientData->id;
            }

        } elseif ( (isClientAdmin()) || (isClientAdvisor()) || (isClientAdvisor()) ){
            $clientId = Auth::guard('admin')->user()->client_id;

        }

        return $clientId;

    }

}




if (!function_exists('getClientUuid'))
{

    function getClientUuid()
    {

        $clientUuid = NULL;

        if ( (strpos( url()->current(), 'admin.') !== false) || (strpos( url()->current(), '/admin/') !== false) )
        {

            if (Auth::guard('admin')->check())
            {

                if (isGlobalAdmin()){

                    //determine if present in the session and is not null
                    if ( session('adminClientSelectorSelection') )
                    {
                        $clientUuid = session('adminClientSelectorSelection');
                    }

                } elseif ( (isClientAdmin()) || (isClientAdvisor()) || (isClientAdvisor()) ){
                    $clientUuid = Auth::guard('admin')->user()->client->uuid;

                }

            }


        } else {

            //if (Route::is('frontend.*'))
            //{
                $clientUuid = session('fe_client')->uuid;

            //}

        }


        return $clientUuid;

    }

}
