<?php

if(!function_exists('showRelativePath'))
{

    function showRelativePath($url)
    {

        $urlDetails = parse_url($url);
        return $urlDetails['path'];

    }

}
