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
