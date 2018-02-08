<?php

namespace Ardiran\Core\Wp\Routing;

use Ardiran\Core\Application\Container;
use Ardiran\Core\Wp\Routing\RouteCollection;
use Ardiran\Core\Wp\Routing\Route;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router as IlluminateRouter;

class Router extends IlluminateRouter{

    /**
     * Build a Router instance.
     *
     * @param Dispatcher $events
     * @param Container $container
     */
    public function __construct(Dispatcher $events, Container $container){

        parent::__construct($events, $container);

        $this->routes = new RouteCollection();

    }

    /**
     * Create a new Route object.
     *
     * @param  array|string $methods
     * @param  string       $uri
     * @param  mixed        $action
     * @return \Ardiran\Core\Routing\Wp\Route
     */
    protected function newRoute($methods, $uri, $action){

        return (new Route($methods, $uri, $action))
            ->setRouter($this)
            ->setContainer($this->container);

    }

    /**
     * Find the route matching a given request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Ardiran\Core\Routing\Wp\Route
     */
    protected function findRoute($request){

        $route = parent::findRoute($request);

        // If the current route is a WordPress route
        if ($route instanceof Route && !$route->condition()) {

            global $wp, $wp_query;

            //Check if the route is not a WordPress route and warn the developer to flush the rewrite rules.
            if ($wp->matched_rule != $route->getRewriteRuleRegex()) {
                /*
                 * We cannot rely on the flush_rewrite_rules() function as it's a heavy process
                 * especially on a per-request manner.
                 * We modify the headers status and set to 200 so it is properly handled.
                 * We need to use WordPress headers functions as we only return the response
                 * content on each request.
                 */
                status_header(200, 'OK');
            }

            // Reset the WordPress query.
            $wp_query->init();

        }

        return $route;

    }

}