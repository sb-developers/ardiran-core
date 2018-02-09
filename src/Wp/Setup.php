<?php

namespace Ardiran\Core\Wp;

use Ardiran\Core\Traits\Singleton;
use Ardiran\Core\Ardiran;

class Setup{

    use Singleton;

    /**
     * Ardiran app.
     *
     * @var Ardiran
     */
    private $app;

    public function __construct(){

        $this->app = Ardiran::getInstance();

    }

    /**
     * Listen to all ajax controllers
     *
     * @param array $ajaxControllers
     */
    public function registerAjaxControllers(array $ajaxControllers){

        array_map(function ($class) {

            call_user_func($class . '::listen');

        }, $ajaxControllers);

    }

}