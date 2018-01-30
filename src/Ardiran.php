<?php

namespace Ardiran\Core;

use Ardiran\Core\Application\Container;
use Ardiran\Core\View\Blade\BladeProvider;
use Ardiran\Core\View\Blade\Blade;
use Ardiran\Core\Config\Config;

class Ardiran{

    private $config;

    public function __construct($config = []){
        
        $this->config = $config;

        $this->setup();

    }

    public function app($abstract = null, $parameters = [], Container $container = null){

        $container = $container ?: Container::getInstance();

        if (!$abstract) {
            return $container;
        }

        return $container->bound($abstract)
            ? $container->makeWith($abstract, $parameters)
            : $container->makeWith("ardiran.{$abstract}", $parameters);

    }

    public function view($file, $data = []){

        return $this->app('blade')->render($file, $data);

    }

    public function config($key = null, $default = null){

        if (is_null($key)) {
            return $this->app('config');
        }

        if (is_array($key)) {
            return $this->app('config')->set($key);
        }

        return $this->app('config')->get($key, $default);

    }

    private function setup(){

        $this->defineConfigValues();
        $this->registerConfig();
        $this->registerBlade();

    }
    
    private function defineConfigValues(){

        $defaults = [
            'theme' => [
                'dir' => get_theme_file_path(),
                'uri' => get_theme_file_uri(),
            ],
            'view' => [ 
                'paths' => [ 
                    get_theme_file_path().'/views',
                    get_parent_theme_file_path().'/views',
                ],
                'compiled' => wp_upload_dir()['basedir'] . '/cache',
                'namespaces' => [ ],
            ]
        ];

        $this->config = array_replace_recursive($defaults, $this->config);

    }

    private function registerConfig(){

        $this->app()->bindIf('config', function () {
            return new Config($this->config);
        }, true);

    }

    private function registerBlade(){

        $this->app()->singleton('ardiran.blade', function (Container $app) {

            $cachePath = $this->config('view.compiled');

            if (!file_exists($cachePath)) {
                wp_mkdir_p($cachePath);
            }

            (new BladeProvider($app))->register();

            return new Blade($app['view']);

        });

    }

}