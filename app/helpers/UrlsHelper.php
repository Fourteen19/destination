<?php

if (!function_exists('get_base_article_url')) {

    function get_base_article_url() {

        $baseUrl = config('app.url').'/article/';

        $parsedUrl = parse_url($baseUrl);
        $host = explode('.', $parsedUrl['host']);

        $baseUrl = remove_first_occurence($baseUrl, $host[0], '*');
        $baseUrl = remove_first_occurence($baseUrl, ':8000', '');
        $baseUrl = remove_first_occurence($baseUrl, ':443', '');

        return $baseUrl;

    }

}


if (!function_exists('get_base_activity_url')) {

    function get_base_activity_url() {

        $baseUrl = config('app.url').'/activity/';

        $parsedUrl = parse_url($baseUrl);
        $host = explode('.', $parsedUrl['host']);

        $baseUrl = remove_first_occurence($baseUrl, $host[0], '*');
        $baseUrl = remove_first_occurence($baseUrl, ':8000', '');
        $baseUrl = remove_first_occurence($baseUrl, ':443', '');

        return $baseUrl;

    }

}



if (!function_exists('get_base_employer_url')) {

    function get_base_employer_url() {

        $baseUrl = config('app.url').'/employer/';

        $parsedUrl = parse_url($baseUrl);
        $host = explode('.', $parsedUrl['host']);

        $baseUrl = remove_first_occurence($baseUrl, $host[0], '*');
        $baseUrl = remove_first_occurence($baseUrl, ':8000', '');
        $baseUrl = remove_first_occurence($baseUrl, ':443', '');

        return $baseUrl;

    }

}



if (!function_exists('get_base_page_url')) {

    function get_base_page_url() {

        $baseUrl = config('app.url').'/page/';
        $baseUrl = remove_first_occurence($baseUrl, ':8000', '');
        $baseUrl = remove_first_occurence($baseUrl, ':443', '');

        return $baseUrl;

    }

}


if (!function_exists('parse_encode_url')) {

    function parse_encode_url($url) {

        $bannerUrlData = parse_url($url);
        $bannerUrlData['path'] = implode('/', array_map('rawurlencode', explode('/', $bannerUrlData['path'] )));
        return unparse_url($bannerUrlData);

    }

}

//recompiles a URL after a parse_url()
if (!function_exists('unparse_url')) {

    function unparse_url($parsed_url) {
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
        $pass     = ($user || $pass) ? "$pass@" : '';
        $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
        return "$scheme$user$pass$host$port$path$query$fragment";
    }

}


if (!function_exists('image_path_fix')) {

    function image_path_fix($path) {

        return str_replace('/', '\\', $path);

    }

}



if (!function_exists('getSubdomain'))
{

    function getSubdomain()
    {

        // Extract the subdomain from URL
        return explode('.', request()->getHost(), 2);


    }

}

