<?php

namespace Ardiran\Core\View\Blade;

use Illuminate\Support\ServiceProvider;
use Ardiran\Core\View\Blade\Blade;

class BladeProvider extends ServiceProvider{

    /**
     * Register the Blade template compiler in the Laravel core.
     *
     * @return void
     */
    public function register(){

        $this->app->singleton('ardiran.blade', function ($container) {

            $paths = $container['ardiran.config']->get('view.paths');
            $compiled = $container['ardiran.config']->get('view.compiled');

            return new Blade($container, $paths, $compiled);
            
        });

    }

}