<?php

if (!function_exists('get_base_article_url')) {

    function get_base_article_url() {

        $baseUrl = config('app.url').'/article/';
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
