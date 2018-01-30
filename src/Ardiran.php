<?php

namespace Ardiran\Core;

use Ardiran\Core\Application\Container;
use Ardiran\Core\View\Blade\Blade;

class Ardiran{

    private $container;

    private $blade;

    private $config;

    public function __construct($config = []){

        $config_defaults = [
            "view" => [ ],
            "controller" => [ ],
        ];

        $this->config = array_replace_recursive($config_defaults, $config);

        $this->container = Container::getInstance();

        $this->blade = Blade::getInstance($config['view']);

    }

    public function blade(){

        return $this->blade;

    }

}