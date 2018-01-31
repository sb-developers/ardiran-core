<?php

namespace Ardiran\Core;

use Ardiran\Core\Application\Container;
use Ardiran\Core\Config\Config;

class Ardiran{

    private static $instance;

    private $container;

    private $config_values;

    private $config;

    public function __construct($config_values){

        $this->checkConfig($config_values);

        $this->config_values = $config_values;

        $this->container = new Container();

        $this->registerConfig();

    }

    public static function getInstance($config_values){

        if (!isset(self::$instance)) {
            self::$instance = new Ardiran($config_values);
        }

        return self::$instance;

    }

    private function checkConfig($config){

        if( !isset($config['config_path']) ){
            die('You must specify the path of the directory where the configuration files are located');
        }

    }

    private function registerConfig(){

        $this->container->bindIf('ardiran.config', function () {
            
            $this->config = new Config();

            $this->config->loadConfigurationFiles(
                $this->config_values['config_path']
            );

            return $this->config;

        }, true);

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