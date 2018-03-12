<?php

namespace Ardiran\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Agent extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.agent';
    }

}