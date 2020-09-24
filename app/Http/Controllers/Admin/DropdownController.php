<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class DropdownController extends Controller
{
    
    public function getClient(Request $request)
    {

        if ($request->ajax()) 
        {
            // The user is logged in...
            if (Auth::check('admin')) 
            {

                $clients = DB::table("clients")
                    ->orderBy('name', 'Asc')
                    ->pluck("name" ,"uuid")
                    ->prepend(trans('ck_admin.pleaseSelect'), '');

                return response()->json($clients, 200);
            
            } else {

                return response()->json($clients, 400);

            }

        }

    }



    public function getInstitution(Request $request)
    {

        if ($request->ajax()) 
        {
            // The user is logged in...
            if (Auth::check('admin')) 
            {

                $client = Client::where('uuid', $request->uuid)->first();

                //$institutions = Institutions::orderBy('name','asc')->pluck("name" ,"uuid")->prepend(trans('ck_admin.pleaseSelect'), '')->all();
                $institutions = DB::table("institutions")
                    ->where('client_id', $client->id)
                    ->orderBy('name', 'Asc')
                    ->pluck("name" ,"uuid")
                    ->prepend(trans('ck_admin.pleaseSelect'), '');

                return response()->json($institutions);
            
            } else {

                return response()->json($clients, 400);

            }

        }

    }
}
