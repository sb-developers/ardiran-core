<?php

namespace Ardiran\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Blade extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.blade';
    }

}