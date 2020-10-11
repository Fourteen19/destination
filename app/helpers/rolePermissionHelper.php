<?php

if(!function_exists('getAdminLevel')) {

    function getAdminLevel($admin) {
        
        //dd($admin);
        
        if ($admin->hasAnyRole(['System Administrator', 'Global Content Admin'])) 
        {
            $admin_level = 3;
        } elseif ($admin->hasAnyRole(['Client Admin', 'Client Content Admin', 'Third Party Admin'])) {
            $admin_level = 2;
        } elseif ($admin->user()->hasAnyRole(['Advisor'])) {
            $admin_level = 1;
        } else {
            $admin_level = 0;
        }

        return $admin_level;
    }
}

?>