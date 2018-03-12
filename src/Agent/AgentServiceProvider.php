<?php

namespace Ardiran\Core\Agent;

use Ardiran\Core\Application\ServiceProvider;
use \Jenssegers\Agent\Agent;

class AgentServiceProvider extends ServiceProvider {

    /**
     * Add object of management of user agent
     *
     * @return void
     */
    public function register(){

        $this->app->singleton(  'ardiran.agent', function ($container) {

            $agent = new Agent($container['ardiran.request']->server->all());

            return $agent;

        });

    }

}