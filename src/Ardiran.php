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
            "views" => [],
        ];

        $this->config = array_replace_recursive($config_defaults, $config);

        $this->container = Container::getInstance();

        $this->blade = Blade::getInstance($config['views']);

    }

    public function blade(){

        return $this->blade;

    }

}