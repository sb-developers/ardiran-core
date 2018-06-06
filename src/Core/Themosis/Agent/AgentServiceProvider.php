<?php

namespace Ardiran\Core\Themosis\Agent;

use \Jenssegers\Agent\Agent;
use Themosis\Foundation\ServiceProvider;

/**
 * Class AgentServiceProvider
 * {@inheritdoc }
 * @package Ardiran\Core\Themosis\Agent
 */
class AgentServiceProvider extends ServiceProvider {

    /**
     * Add object of management of user agent
     *
     * @return void
     */
    public function register(){

        $this->app->singleton(  'ardiran.agent', function ($container) {

            $agent = new Agent($container['request']->server->all());

            return $agent;

        });

    }

}