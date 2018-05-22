<?php

namespace Ardiran\Core\Facades;

use Themosis\Facades\Facade;

class Agent extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.agent';
    }

}