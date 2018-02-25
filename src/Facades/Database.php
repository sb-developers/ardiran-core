<?php

namespace Ardiran\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Database extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.database';
    }

}