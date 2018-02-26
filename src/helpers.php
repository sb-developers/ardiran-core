<?php

use Ardiran\Core\Ardiran;

if (!function_exists('ardiran')) {

    /**
     * Helper function to quickly retrieve an instance.
     *
     * @param null  $abstract   The abstract instance name.
     * @param array $parameters
     *
     * @return mixed
     */
    function ardiran($abstract = null, array $parameters = []){

        if (is_null($abstract)) {
            return Ardiran::getInstance();
        }

        return Ardiran::getInstance()->container($abstract, $parameters);

    }

}

if (! function_exists('url')) {

    /**
     * Generate a url for the application.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @param  bool    $secure
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function url($path, $parameters = [], $secure = null){
        return ardiran('ardiran.urlgenerator')->to($path, $parameters, $secure);
    }

}

if (! function_exists('secure_url')) {

    /**
     * Generate a HTTPS url for the application.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function secure_url($path, $parameters = []){
        return urlWp($path, $parameters, true);
    }

}

