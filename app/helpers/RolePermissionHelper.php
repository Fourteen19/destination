<?php

if (!function_exists('getAdminLevel'))
{

    function getAdminLevel($admin)
    {

        if ($admin->hasAnyRole([config('global.admin_user_type.System_Administrator'), config('global.admin_user_type.Global_Content_Admin')]))
        {
            $adminLevel = 3;
        } elseif ($admin->hasAnyRole([config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), config('global.admin_user_type.Third_Party_Admin')])) {
            $adminLevel = 2;
        } elseif ($admin->hasAnyRole([config('global.admin_user_type.Advisor'), config('global.admin_user_type.Teacher')])) {
            $adminLevel = 1;
        } else {
            $adminLevel = 0;
        }

        return $adminLevel;
    }
}


if (!function_exists('isGlobalAdmin'))
{

    function isGlobalAdmin()
    {

        if (Session::get('adminAccessLevel') == 3)
            return True;
        }

}

if (!function_exists('isClientAdmin'))
{

    function isClientAdmin()
    {

        if (Session::get('adminAccessLevel') == 2)
            return True;
        }

}



if (!function_exists('isClientAdvisor'))
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


if (!function_exists('isClientTeacher'))
{

    function isClientTeacher($admin)
    {

        if ($admin->hasAnyRole([config('global.admin_user_type.Teacher')])) {
            return True;
        }
    }
}



if (!function_exists('isEmployer'))
{

    function isEmployer($admin)
    {

        if ($admin->hasAnyRole([config('global.admin_user_type.Employer')])) {
            return True;
        }
    }
}




if (!function_exists('AdminHasClient'))
{

    function adminHasClient($admin)
    {

        if ($admin->hasAnyRole([config('global.admin_user_type.Client_Admin'),
                                config('global.admin_user_type.Client_Content_Admin'),
                                config('global.admin_user_type.Advisor'),
                                config('global.admin_user_type.Teacher'),
                            ])) {
            return True;
        }
    }
}



if (!function_exists('adminHasRole'))
{

    function adminHasRole($admin, $role)
    {

        if ($admin->hasRole([$role])) {
            return True;
        }
    }
}



?>
