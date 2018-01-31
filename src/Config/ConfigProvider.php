<?php

namespace Ardiran\Core\Config;

use Illuminate\Support\ServiceProvider;
use Ardiran\Core\Config\Config;

class ConfigProvider extends ServiceProvider{

    public function register(){

        $this->app->bindIf('ardiran.config', function () {
            
            return new Config();

        }, true);

    }

}