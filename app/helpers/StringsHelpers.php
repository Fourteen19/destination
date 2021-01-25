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
        return $query = implode(" ", $query);

    }

}
