<?php

namespace Ardiran\Core\Wp\Routing\Matching;

use Ardiran\Core\Http\Request;
use Ardiran\Core\Wp\Routing\Route;

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