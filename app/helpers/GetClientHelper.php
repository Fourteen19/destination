<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


if(!function_exists('getClientId'))
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

        } elseif (isClientAdmin()){
            $clientId = Auth::guard('admin')->user()->client_id;//session('client');

        }

        return $clientId;

    }

}




if(!function_exists('getClientUuid'))
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

                } elseif (isClientAdmin()){
                    $clientUuid = Auth::guard('admin')->user()->client()->uuid;

                }

            }


        } else {

            if (Route::is('frontend.*'))
            {
                $clientUuid = session('fe_client')->uuid;

            }

        }


        return $clientUuid;

    }

}
