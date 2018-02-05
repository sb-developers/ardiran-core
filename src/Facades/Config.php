<?php

namespace Ardiran\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Config extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.config';
    }

}