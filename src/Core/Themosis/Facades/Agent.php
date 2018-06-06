<?php

namespace Ardiran\Core\Themosis\Facades;

use Themosis\Facades\Facade;

/**
 * Class Agent
 * {@inheritdoc }
 * @package Ardiran\Core\Themosis\Facades
 */
class Agent extends Facade {

    protected static function getFacadeAccessor() {
        return 'ardiran.agent';
    }

}