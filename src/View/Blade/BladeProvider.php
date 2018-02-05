<?php

namespace Ardiran\Core\View\Blade;

use Ardiran\Core\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Ardiran\Core\View\Blade\Blade;
use Ardiran\Core\View\Blade\BladeException;

class BladeProvider extends ServiceProvider{

    /**
     * Register the Blade template compiler in the Laravel core.
     *
     * @return void
     */
    public function register(){

        $this->app->singleton('ardiran.blade', function ($container) {

            if( !Config::has('view.paths') || !Config::has('view.compiled') ){
                throw new BladeException("You must add to the configuration the 'view.paths' and 'view.compiled' in config directory.");
            }

            $paths = Config::get('view.paths');
            $compiled = Config::get('view.compiled');

            return new Blade($container, $paths, $compiled);
            
        });

    }

}