<?php

if(!function_exists('getAdminLevel')) {

    function getAdminLevel($admin) {

        if ($admin->hasAnyRole(['System Administrator', 'Global Content Admin']))
        {
            $admin_level = 3;
        } elseif ($admin->hasAnyRole(['Client Admin', 'Client Content Admin', 'Third Party Admin'])) {
            $admin_level = 2;
        } elseif ($admin->hasAnyRole(['Advisor'])) {
            $admin_level = 1;
        } else {
            $admin_level = 0;
        }

        return $admin_level;
    }
}


if(!function_exists('getAdminLevelByRole')) {

    function getAdminLevelByRole($role) {

        if (in_array($role, ['System Administrator', 'Global Content Admin']))
        {
            $admin_level = 3;
        } elseif (in_array($role, ['Client Admin', 'Client Content Admin', 'Third Party Admin'])) {
            $admin_level = 2;
        } elseif (in_array($role, ['Advisor'])) {
            $admin_level = 1;
        } else {
            $admin_level = 0;
        }

        return $admin_level;
    }
}


?>
