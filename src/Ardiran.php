<?php

namespace Ardiran\Core;

use Ardiran\Core\Application\Container;
use Ardiran\Core\Config\Config;
use Ardiran\Core\Traits\Singleton;

class Ardiran{

    use Singleton;

    private $container;

    private $config;

    public function __construct(){

        $this->container = new Container();

        $this->config = new Config();

    }

    public function container($abstract = null, $parameters = []){
       
        if (!$abstract) {
            return $this->container;
        }

        return $this->container->bound($abstract)
            ? $this->container->make($abstract, $parameters)
            : $this->container->make("ardiran.{$abstract}", $parameters);

    }

    public function config($key){

        return $this->container('ardiran.config')->get($key);

    }

}