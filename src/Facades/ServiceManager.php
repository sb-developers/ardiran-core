<?php

namespace Ardiran\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ServiceManager extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.servicemanager';
    }

}