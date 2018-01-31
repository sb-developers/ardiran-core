<?php

namespace Ardiran\Core\View\Blade;

use Illuminate\Support\ServiceProvider;
use Ardiran\Core\View\Blade\Blade;

class BladeProvider extends ServiceProvider{

    public function register(){
        
        $this->app->singleton('ardiran.blade', function ($container) {
            return new Blade($container['ardiran.config']->get('view'));
        });

    }

}