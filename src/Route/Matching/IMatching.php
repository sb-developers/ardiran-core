<?php

namespace Ardiran\Core\Route\Matching;

use Ardiran\Core\Http\Request;
use Ardiran\Core\Route\Route;

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