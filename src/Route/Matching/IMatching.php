<?php

namespace Ardiran\Core\Route\Matching;

use Ardiran\Core\Http\Request;
use Ardiran\Core\Route\Route;

/**
 * Class IMatching
 *
 * @author Themosis
 * @url https://github.com/themosis/framework/blob/1.3/src/Themosis/Route/Matching/IMatching.php
 */
interface IMatching{

    /**
     * Validate a given rule against a route and request.
     *
     * @param Route $route
     * @param Request $request
     * @return mixed
     */
    public function matches(Route $route, Request $request);

}