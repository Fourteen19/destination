<?php

namespace App\Http\Services\Alexusmai\LaravelFileManager;

use Illuminate\Support\Facades\Auth;
use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;

class UsersACLRepository implements ACLRepository
{


    public function __construct()
    {
        //
    }


    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return \Auth::guard('admin')->id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {

        //if the current admin has NO client_id associated to it, ie. "super addmin", then it is has access to all clients folders
        if (is_null(Auth::guard('admin')->user()->client_id)) {

            //returns a list of paths
            return [
                ['disk' => 'public', 'path' => '/', 'access' => 2],
                ['disk' => 'public', 'path' => '*', 'access' => 2]
            ];

        //else if this is a client user, we only allow access to their respective client folder and subfolders
        } else {

            //returns a list of paths
            return [
                ['disk' => 'public', 'path' => '/', 'access' => 2],
                ['disk' => 'public', 'path' => Auth::guard('admin')->user()->client->subdomain , 'access' => 1],
                ['disk' => 'public', 'path' => Auth::guard('admin')->user()->client->subdomain .'/*' , 'access' => 2]
            ];
        }

      //  return [];


      /*
    return[
        ['disk' => 'public', 'path' => '/', 'access' => 1],
        ['disk' => 'public', 'path' => 'sxnwqnhqit', 'access' => 2],
        ['disk' => 'public', 'path' => 'sxnwqnhqit/*', 'access' => 2],


        //['disk' => 'public', 'path' => '/sltwcyprqh/*', 'access' => 2],
    ];*/

    }
}
