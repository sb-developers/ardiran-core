<?php

namespace Ardiran\Core\Wp\Routing\Matching;

use Ardiran\Core\Http\Request;
use Ardiran\Core\Wp\Routing\Route;

class ConditionMatching implements IMatching{

    public function matches(Route $route, Request $request){

        // Check if a template is associated and compare it to current route condition.
        if ($route->condition() && call_user_func_array($route->condition(), [$route->conditionalParameters()])) {
            return true;
        }

        return false;

    }

}