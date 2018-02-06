<?php

namespace Ardiran\Core\Facades;

use Ardiran\Core\Application\ServiceProvider;
use Illuminate\Support\Facades\Facade;

class FacadeProvider extends ServiceProvider {

    /**
     * Register the container in Facade object base.
     * It is necessary to later find the accesors inside the container.
     *
     * @return void
     */
    public function register(){

        Facade::setFacadeApplication( $this->app );

    }

}