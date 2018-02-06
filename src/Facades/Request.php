<?php

namespace Ardiran\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Request extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.request';
    }

}