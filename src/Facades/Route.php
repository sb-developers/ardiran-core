<?php

namespace Ardiran\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Route extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.router';
    }

}