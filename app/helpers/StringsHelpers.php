<?php

if(!function_exists('remove_common_words')) {

    function remove_common_words($searchString) {
        $commonWords = \Lang::get('ck_front.commonWords');
        $search = explode(" ", $searchString);

        foreach($search as $value){
            if(!in_array(trim($value), $commonWords)){
               $query[] = $value;
            }
        }

        if (!empty($query)){
            $res = implode(" ", $query);
        } else {
            $res = [];
        }

        return $res;

    }

}



if(!function_exists('remove_first_occurence')) {

    function remove_first_occurence($haystack, $needle, $replace) {

        $pos = strpos($haystack, $needle);
        if ($pos !== false) {
            return substr_replace($haystack, $replace, $pos, strlen($needle));
        }

        return $haystack;
    }

}


