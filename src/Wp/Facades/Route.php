<?php

namespace Ardiran\Core\Wp\Facades;

use Illuminate\Support\Facades\Facade;

class Route extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.wp_router';
    }

}