<?php

namespace Ardiran\Core\Facades;

use Illuminate\Support\Facades\Facade;

class View extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.view';
    }

}