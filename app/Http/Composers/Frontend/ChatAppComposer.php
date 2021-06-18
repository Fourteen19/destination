<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ClientService;

class ChatAppComposer
{

    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;

    }


    public function compose(View $view)
    {

        //If not logged in, get the chat app
        if (!Auth::guard('web')->check())
        {

            $view->with('chatApp', $this->clientService->getChatApp() );

        }

    }


}
