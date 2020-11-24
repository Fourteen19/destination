<?php

if(!function_exists('getAdminLevel')) {

    function getAdminLevel($admin) {

        if ($admin->hasAnyRole(['System Administrator', 'Global Content Admin']))
        {
            $adminLevel = 3;
        } elseif ($admin->hasAnyRole(['Client Admin', 'Client Content Admin', 'Third Party Admin'])) {
            $adminLevel = 2;
        } elseif ($admin->hasAnyRole(['Advisor'])) {
            $adminLevel = 1;
        } else {
            $adminLevel = 0;
        }

        return $adminLevel;
    }
}

?>
