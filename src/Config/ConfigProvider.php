<?php

namespace Ardiran\Core\Config;

use Ardiran\Core\Application\ServiceProvider;
use Ardiran\Core\Config\ConfigRepository;

class ConfigProvider extends ServiceProvider {
    
    /**
     * We register the configuration repository in the Laravel core.
     *
     * @return void
     */
    public function register(){

        $this->app->bindIf('ardiran.config', function () {
            return new ConfigRepository();
        }, true);

    }

}