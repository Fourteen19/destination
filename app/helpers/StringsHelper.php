<?php

function arrayCastRecursive($array)
{
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = arrayCastRecursive($value);
            }
            if ($value instanceof stdClass) {
                $array[$key] = arrayCastRecursive((array)$value);
            }
        }
    }
    if ($array instanceof stdClass) {
        return arrayCastRecursive((array)$array);
    }
    return $array;
}




if (!function_exists('lastAnd'))
{
    function lastAnd(string $string, string $word = 'and', string $glue = ', '): string
    {
        $pos = strrpos($string, $glue);
        if ($pos)
        {
            return substr_replace($string, ' '.$word, $pos, 1);
        } else {
            return $string;
        }
    }
}



if (!function_exists('remove_common_words'))
{

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
            $res = "";
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


