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
        return url($path, $parameters, true);
    }

}

if (!function_exists('assets_images')) {

    /**
     * Helper function to obtain image url.
     *
     * @param null  $image_path   Image path relative to 'paths-resources.images'
     *
     * @return String
     */
    function assets_images($image_path = ''){

        if(!ardiran('ardiran.config')->has('theme.paths-resources.images')){
            throw new Exception("You must add to the configuration the 'theme.paths-resources.images' in config directory.");
        }

        return ardiran('ardiran.config')->get('theme.paths-resources.images') . $image_path;

    }

}