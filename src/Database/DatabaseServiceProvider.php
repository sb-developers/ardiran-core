<?php

namespace Ardiran\Core\Database;

use Ardiran\Core\Application\ServiceProvider;
use Illuminate\Database\Capsule\Manager as Capsule;
use Ardiran\Core\Facades\Config;

class DatabaseServiceProvider extends ServiceProvider {

    /**
     * Add object of management of the database and the different connections.
     *
     * @return void
     */
    public function register(){

        $this->app->singleton(  'ardiran.database', function ($container) {

            // Create capsule
            $capsule = new Capsule();

            // Add diferents connections
            if(Config::has('database.connections')) {

                foreach (Config::get('database.connections') as $connectionName => $connectionConfig) {
                    $capsule->addConnection($connectionConfig, $connectionName);
                }

            }

            // Set the event dispatcher used by Eloquent models...
            $capsule->setEventDispatcher($container['ardiran.events']);

            // Make this Capsule instance available globally via static methods...
            $capsule->setAsGlobal();

            // Setup the Eloquent ORM...
            $capsule->bootEloquent();

            return $capsule;

        });

    }

}