<?php

namespace App\Services\Admin;

use App\Models\StaticClientContent;


Class AdminClientContentSettingsService
{

    public function __construct()
    {

    }


    public function getVacanciesAdminRecipients($clientId)
    {
       // dd( StaticClientContent::select('vacancy_email_notification')->where('client_id', $clientId )->get()->first() );
        return StaticClientContent::select('vacancy_email_notification')->where('client_id', $clientId )->get()->first();
    }


}
