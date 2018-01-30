<?php

namespace Ardiran\Core;

use Ardiran\Core\Application\Container;
use Ardiran\Core\Setup;

class Ardiran{

    private $container;

    private $config;

    public function __construct($config = []){

        $this->container = Container::getInstance();
        $this->config = $config;

        $this->setup();

    }

    public function app($abstract = null, $parameters = [], Container $container = null){

        $container = $container ?: $this->container;

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

        Setup::registerConfig($this->container, $this->config);
        Setup::registerBlade($this->container);

    }

}