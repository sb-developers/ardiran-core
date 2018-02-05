<?php

namespace Ardiran\Core;

use Ardiran\Core\Application\Container;
use Ardiran\Core\Traits\Singleton;

class Ardiran{

    use Singleton;

    /**
     * Instance of Laravel Container.
     *
     * @var Container
     */
    private $container;
    
    /**
     * Constructor
     */
    public function __construct(){

        $this->container = new Container();

    }

    /**
     * Allows access to container functionalities or obtain the container.
     *
     * @param string $abstract
     * @param array $parameters
     * @return void
     */
    public function container($abstract = null, $parameters = []){
       
        if (!$abstract) {
            return $this->container;
        }

        return $this->container->bound($abstract)
            ? $this->container->make($abstract, $parameters)
            : $this->container->make("ardiran.{$abstract}", $parameters);

    }

}