<?php

if(!function_exists('getAdminLevel'))
{

    function getAdminLevel($admin)
    {

        if ($admin->hasAnyRole(['System Administrator', 'Global Content Admin']))
        {
            $adminLevel = 3;
        } elseif ($admin->hasAnyRole(['Client Admin', 'Client Content Admin', 'Third Party Admin'])) {
            $adminLevel = 2;
        } elseif ($admin->hasAnyRole(['Advisor', 'Teacher'])) {
            $adminLevel = 1;
        } else {
            $adminLevel = 0;
        }

        return $adminLevel;
    }
}


if(!function_exists('isGlobalAdmin'))
{

    function isGlobalAdmin()
    {

        if (Session::get('adminAccessLevel') == 3)
            return True;
        }

}

if(!function_exists('isClientAdmin'))
{

    function isClientAdmin()
    {

        if (Session::get('adminAccessLevel') == 2)
            return True;
        }

}



if(!function_exists('isClientAdvisor'))
{

    /**
     * isClientAdvisor
     * includes advisors and teachers
     *
     * @return void
     */
    function isClientAdvisor()
    {

        if (Session::get('adminAccessLevel') == 1)
            return True;
        }

}

?>
